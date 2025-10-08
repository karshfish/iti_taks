// src/app/app.routes.ts
import { Routes } from '@angular/router';
import { Home } from './home/home';
import { About } from './about/about';
import { Products } from './products/products';
import { ProductDetails } from './product-details/product-details';
import { Recipes } from './recipes/recipes';

export const routes: Routes = [
  { path: '', component: Home },
  { path: 'about', component: About },
  { path: 'products', component: Products },
  { path: 'details/:id', component: ProductDetails },
  { path: 'recipes', component: Recipes },
  { path: '**', redirectTo: '' },
];
