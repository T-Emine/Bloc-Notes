import { Component, OnInit } from '@angular/core';
import { CategorieService } from '../categorie.service';
import { Categorie } from '../categorie';

@Component({
  selector: 'app-categorie',
  templateUrl: './categorie.component.html',
  styleUrls: ['./categorie.component.css']
})
export class CategorieComponent implements OnInit {
  cat: Categorie[];

  constructor(
    private categorieService:CategorieService
  ) { }

  ngOnInit() { }

 /*
  * Méthode pour afficher la liste des catégories
  */
  getCategorie(): void {
    this.categorieService.getCategorie().subscribe(cat => this.cat = cat);
  }
 
/*
  * Méthode pour supprimer une catégories
  */
  deleteCat(catDel: Categorie): void {
    this.cat = this.cat.filter(c => c !== catDel); //enleve la ligne
    this.categorieService.deleteCat(catDel).subscribe();
  }
 
}
 
 