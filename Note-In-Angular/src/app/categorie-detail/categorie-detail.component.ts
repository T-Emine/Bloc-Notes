import { Component, OnInit, Input } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';
import { Categorie }         from '../categorie';
import { CategorieService }  from '../categorie.service';
 
@Component({
  selector: 'app-categorie-detail',
  templateUrl: './categorie-detail.component.html',
  styleUrls: ['./categorie-detail.component.css']
})

export class CategorieDetailComponent implements OnInit {
  @Input() catInput: Categorie;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private categorieService: CategorieService,
    private location: Location
  ) { }

  ngOnInit() {
    this.getCatDetail();
  }

 /*
  * Méthode qui affiche la catégorie qui va être modifiée
  * avec les cases préremplies
  */
  getCatDetail(): void {
    const id = +this.route.snapshot.paramMap.get('id');
    this.categorieService.getCategorieID(id).subscribe(cat => this.catInput = cat);
  }
 
 /*
  * Méthode pour le retour du bouton "Back"
  */
  goBack(): void {
    this.location.back();
  }

  //PUT chercher bd+save
 /*
  * Méthode pour le sauver la catégorie modifiée
  */
  saveCat(catSave: Categorie) : void {
    this.categorieService.saveCat(catSave).subscribe();
    alert("La catégorie à bien été modifiée !");
  }


}
