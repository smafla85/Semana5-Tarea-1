import { Component, OnInit } from '@angular/core';
import { SharedModule } from 'src/app/theme/shared/shared.module';
import { IFactura } from '../Interfaces/factura';
import { Router, RouterLink } from '@angular/router';
import { FacturaService } from '../Services/factura.service';
import Swal from 'sweetalert2';

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
      error: (e) => {
        console.error('Error al cargar las facturas', e);
        Swal.fire('Error', 'No se pudieron cargar las facturas', 'error');
      }
    });
  }

  eliminar(idFactura: number): void {
    Swal.fire({
      title: '¿Está seguro?',
      text: "¿Desea eliminar esta factura? Esta acción no se puede deshacer.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.facturaServicio.eliminar(idFactura).subscribe({
          next: (respuesta: number) => {
            if (respuesta === 1) {
              Swal.fire(
                'Eliminada',
                'La factura ha sido eliminada con éxito',
                'success'
              );
              this.cargarFacturas(); // Recargar la lista de facturas
            } else {
              Swal.fire(
                'Error',
                'No se pudo eliminar la factura',
                'error'
              );
            }
          },
          error: (e) => {
            console.error('Error al eliminar la factura', e);
            Swal.fire(
              'Error',
              'Ocurrió un error al intentar eliminar la factura',
              'error'
            );
          }
        });
      }
    });
  }

  editarFactura(idFactura: number): void {
    this.router.navigate(['/editarfactura', idFactura]);
  }
}