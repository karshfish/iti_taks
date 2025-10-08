import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { irecipe } from '../models/recipe.model';

@Injectable({
  providedIn: 'root',
})
export class RecipesService {
  private apiUrl = 'recipes.json';

  constructor(private http: HttpClient) {}

  getrecipes(): Observable<irecipe[]> {
    return this.http.get<irecipe[]>(this.apiUrl);
  }
}
