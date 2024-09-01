import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { IFactura } from 'src/app/Interfaces/factura';
import { ICliente } from 'src/app/Interfaces/icliente';
import { ClientesService } from 'src/app/Services/clientes.service';
import { FacturaService } from 'src/app/Services/factura.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-nuevafactura',
  standalone: true,
  imports: [CommonModule, FormsModule, ReactiveFormsModule],
  templateUrl: './nuevafactura.component.html',
  styleUrl: './nuevafactura.component.scss'
})
export class NuevafacturaComponent implements OnInit {
  titulo = 'Nueva Factura';
  listaClientes: ICliente[] = [];
  listaClientesFiltrada: ICliente[] = [];
  totalapagar: number = 0;
  frm_factura: FormGroup;
  idFactura: number | null = null;
  ivaFijo: number = 0.15; // Valor fijo del IVA

  constructor(
    private clietesServicios: ClientesService,
    private facturaService: FacturaService,
    private navegacion: Router,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.frm_factura = new FormGroup({
      Fecha: new FormControl('', Validators.required),
      Sub_total: new FormControl('', Validators.required),
      Sub_total_iva: new FormControl('', Validators.required),
      Valor_IVA: new FormControl(this.ivaFijo, Validators.required),
      Clientes_idClientes: new FormControl('', Validators.required)
    });

    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.idFactura = +id;
      this.titulo = 'Editar Factura';
      this.cargarFactura(this.idFactura);
    }

    this.cargarClientes();
  }

  cargarClientes(): void {
    this.clietesServicios.todos().subscribe({
      next: (data) => {
        this.listaClientes = data;
        this.listaClientesFiltrada = data;
      },
      error: (e) => {
        console.log(e);
      }
    });
  }

  cargarFactura(id: number): void {
    this.facturaService.uno(id).subscribe({
      next: (factura: IFactura) => {
        this.frm_factura.patchValue({
          Fecha: factura.Fecha,
          Sub_total: factura.Sub_total,
          Sub_total_iva: factura.Sub_total_iva,
          Valor_IVA: this.ivaFijo, // Siempre usamos el valor fijo
          Clientes_idClientes: factura.Clientes_idClientes
        });
        this.calculos();
      },
      error: (e) => console.error('Error al cargar la factura', e)
    });
  }

  grabar() {
    if (this.frm_factura.valid) {
      let factura: IFactura = this.frm_factura.value;
      factura.Valor_IVA = this.ivaFijo; // Aseguramos que siempre se use el valor fijo
      
      if (this.idFactura) {
        factura.idFactura = this.idFactura;
        this.facturaService.actualizar(factura).subscribe({
          next: (respuesta) => {
            if (respuesta) {
              alert('Factura actualizada con éxito');
              this.navegacion.navigate(['/facturas']);
            }
          },
          error: (e) => console.error('Error al actualizar la factura', e)
        });
      } else {
        this.facturaService.insertar(factura).subscribe({
          next: (respuesta) => {
            if (parseInt(respuesta) > 0) {
              alert('Factura grabada');
              this.navegacion.navigate(['/facturas']);
            }
          },
          error: (e) => console.error('Error al insertar la factura', e)
        });
      }
    }
  }

  calculos() {
    let sub_total = this.frm_factura.get('Sub_total')?.value;
    if (sub_total) {
      let sub_total_iva = sub_total * this.ivaFijo;
      this.frm_factura.get('Sub_total_iva')?.setValue(sub_total_iva, { emitEvent: false });
      this.totalapagar = parseFloat(sub_total) + sub_total_iva;
    }
  }

  cambio(objetoSleect: any) {
    let idCliente = objetoSleect.target.value;
    this.frm_factura.get('Clientes_idClientes')?.setValue(idCliente);
  }
}