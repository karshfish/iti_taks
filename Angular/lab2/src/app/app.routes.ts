// src/app/app.routes.ts
import { Routes } from '@angular/router';
import { Home } from './home/home';
import { About } from './about/about';
import { Products } from './products/products';

export const routes: Routes = [
  { path: '', component: Home },
  { path: 'about', component: About },
  { path: 'products', component: Products },
  { path: '**', redirectTo: '' }
];
