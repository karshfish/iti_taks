import { Component, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { Product } from '../models/product.model';
import { CommonModule } from '@angular/common';
import { ProductService } from '../services/product.service';

@Component({
  selector: 'app-products',
  templateUrl: './products.html',
  standalone: true,
  imports: [CommonModule, RouterLink],
  styleUrls: ['./products.css'],
})
export class Products implements OnInit {
  products: Product[] = [];
  loading = true;

  error: string | null = null;

  constructor(private productService: ProductService) {}

  ngOnInit(): void {
    this.productService.getProducts().subscribe({
      next: (data) => {
        this.products = data.products;
        this.loading = false;
      },
      error: () => {
        this.error = 'Failed to load products';
        this.loading = false;
      },
    });
  }
  addToCart(product: Product) {
    console.log('Added to cart:', product);
    alert(`${product.title} added to cart!`);
  }
}
