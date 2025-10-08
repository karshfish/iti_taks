import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-product-details',
  imports: [],
  templateUrl: './product-details.html',
  styleUrl: './product-details.css',
})
export class ProductDetails {
  public id: string = '';
  constructor(activeroute: ActivatedRoute) {
    this.id = activeroute.snapshot.params['id'];
  }
}
