import { Component, OnInit, Input } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';
import { Categorie }         from '../categorie';
import { CategorieService }  from '../categorie.service';

@Component({
  selector: 'app-categorie-add-new',
  templateUrl: './categorie-add-new.component.html',
  styleUrls: ['./categorie-add-new.component.css']
})

export class CategorieAddNewComponent implements OnInit {
  catAddInput: string; //car api rest ne crée que le libelle id générer automatiquement

  constructor(    
    private location: Location,
    private categorieService: CategorieService
  ){}

  ngOnInit() {
  }
 
  goBack(): void {
    this.location.back();
  }

  addCat(name: string): void {
    console.log(name);
    this.categorieService.addCat(name).subscribe();
    alert("La catégorie à bien été ajouté !");
  }
}
