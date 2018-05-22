import { Component } from '@angular/core';
import {Router} from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
})

export class AppComponent {
  constructor(
    private router: Router
  ){}

   
 /*
  * Méthode pour aller dans la partie note
  */
  gotoNote() : void{
    this.router.navigate(['/note']);
  }

   
 /*
  * Méthode pour aller dans la partie catégorie
  */
  gotoCat() : void{
    this.router.navigate(['/cat']);
  }

}