import { Component, OnInit, Input } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';
import { NoteService } from '../note.service';
import { Note } from '../note';
import { Categorie }         from '../categorie';
import { CategorieService }  from '../categorie.service';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-note-add-new',
  templateUrl: './note-add-new.component.html',
  styleUrls: ['./note-add-new.component.css']
})
export class NoteAddNewComponent implements OnInit {
  noteAddInput: Note;
  tabCat : Categorie[];
  s:Date;

  constructor(
    private location: Location,
    private categorieService: CategorieService,
    private noteService: NoteService
  ) { this.noteAddInput = new Note() }

  ngOnInit() {
    this.getListCategorie();
  }

  goBack(): void {
    this.location.back();
  }

  addNote(name: Note): void {
    var a = name.date;
    var y = a['year'];
    var m = a['month'];
    var d = a['day'];
    var k = y+"-"+m+"-"+d;
    
    this.s=new Date(k);
    console.log(name);
    console.log(name.date);

    console.log(k);
    console.log(y);
    console.log(m);
    console.log(d);
    name.date=this.s;
    name.contenu = '<?xml version="1.0" encoding="UTF-8"?> <contenu>'+name.contenu+'</contenu>';
    this.noteService.addNote(name).subscribe();
    alert("La note à bien été ajouté !");
  }

  getListCategorie(): void {
    this.categorieService.getCategorie().subscribe(cat => this.tabCat = cat);;
  }

}
