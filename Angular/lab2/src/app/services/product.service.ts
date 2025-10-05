import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Product } from '../models/product.model';

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  private apiUrl = 'products.json';

  constructor(private http: HttpClient) {}

  getProducts(): Observable<{ products: Product[] }> {
  return this.http.get<{ products: Product[] }>(this.apiUrl);
}

}
