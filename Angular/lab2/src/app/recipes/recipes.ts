import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RecipesService } from '../services/recipes.service';
import { irecipe } from '../models/recipe.model';

@Component({
  selector: 'app-recipes',
  imports: [CommonModule],
  templateUrl: './recipes.html',
  styleUrl: './recipes.css',
})
export class Recipes implements OnInit {
  recipes: irecipe[] = [];
  constructor(private recipesService: RecipesService) {}
  ngOnInit(): void {
    this.recipesService.getrecipes().subscribe({
      next: (data) => {
        console.log(data);
        this.recipes = data;
      },
    });
  }
}
