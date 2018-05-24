import { Component, OnInit, Input } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { Note }         from '../note';
import { Categorie }         from '../categorie';
import { NoteService }  from '../note.service';
import { CategorieService }  from '../categorie.service';
import { DatePipe } from '@angular/common';


@Component({
  selector: 'app-note-detail',
  templateUrl: './note-detail.component.html',
  styleUrls: ['./note-detail.component.css']
})
export class NoteDetailComponent implements OnInit {

  @Input() noteInput: Note;
  tabCat : Categorie[];
 
   s:Date;

  constructor(
    private route: ActivatedRoute,
    private noteService: NoteService,
    private categorieService: CategorieService,
    private location: Location,
    private router : Router

  ) { }

  ngOnInit() {
    this.getNoteDetail();
    this.getListCategorie();
  }

   
 /*
  * Méthode pour afficher les détails d'une note à modifiée
  * via son id
  */
  getNoteDetail(): void {
    const id = +this.route.snapshot.paramMap.get('id');
    this.noteService.getNoteID(id).subscribe(note => this.noteInput = note);
  }
 
   
 /*
  * Méthode pour le retour du bouton "Back"
  */
  goBack(): void {
    this.location.back();
  }

  //PUT chercher bd+save
 /*
  * Méthode pour enregistrer une note modifiée
  */
  saveNote(noteSave: Note): void {
    var y = noteSave.date['year'];
    var m = noteSave.date['month'];
    var d = noteSave.date['day'];
    var k = y+"-"+m+"-"+d;
    this.s=new Date(k);//"2018-01-02");
    console.log(k);
    console.log(y);
    console.log(m);
    console.log(d);
    noteSave.date=this.s;
    this.noteService.saveNote(noteSave).subscribe();
    alert("La note à bien été modifié !");
  }

   
 /*
  * Méthode pour avoir la liste de catégorie dans le scroll barre
  */
  getListCategorie(): void {
    this.categorieService.getCategorie().subscribe(cat => this.tabCat = cat);;
  }

}
