import { Component, OnInit } from '@angular/core';
import { SharedModule } from 'src/app/theme/shared/shared.module';
import { IFactura } from '../Interfaces/factura';
import { Router, RouterLink } from '@angular/router';
import { FacturaService } from '../Services/factura.service';

@Component({
  selector: 'app-facturas',
  standalone: true,
  imports: [SharedModule, RouterLink],
  templateUrl: './facturas.component.html',
  styleUrl: './facturas.component.scss'
})
export class FacturasComponent implements OnInit {
  listafacturas: IFactura[] = [];

  constructor(private facturaServicio: FacturaService, private router: Router) {}

  ngOnInit(): void {
    this.cargarFacturas();
  }

  cargarFacturas(): void {
    this.facturaServicio.todos().subscribe({
      next: (data: IFactura[]) => {
        this.listafacturas = data;
      },
      error: (e) => console.error('Error al cargar las facturas', e)
    });
  }

  eliminar(idFactura: number): void {
    if (confirm('¿Está seguro de que desea eliminar esta factura?')) {
      this.facturaServicio.eliminar(idFactura).subscribe({
        next: (respuesta: number) => {
          if (respuesta === 1) {
            alert('Factura eliminada con éxito');
            this.cargarFacturas(); // Recargar la lista de facturas
          } else {
            alert('Error al eliminar la factura');
          }
        },
        error: (e) => console.error('Error al eliminar la factura', e)
      });
    }
  }

  editarFactura(idFactura: number): void {
    this.router.navigate(['/editarfactura', idFactura]);
  }
}