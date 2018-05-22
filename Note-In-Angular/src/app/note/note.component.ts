import { Component, OnInit } from '@angular/core';
import { NoteService } from '../note.service';
import { Note } from '../note';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-note',
  templateUrl: './note.component.html',
  styleUrls: ['./note.component.css']
})
export class NoteComponent implements OnInit {
  note: Note[];

  constructor(private noteService:NoteService) {}

  ngOnInit() {}
 
/*
 * Méthode pour récupérer la liste des notes
 */
  getNote(): void {
    this.noteService.getNote().subscribe(note => this.note = note);
  }
 
 /*
  * Méthode pour supprimer une note
  */
  deleteNote(note: Note): void {
    this.note = this.note.filter(n => n !== note); //enleve la ligne
    this.noteService.deleteNote(note).subscribe();
  }
}
