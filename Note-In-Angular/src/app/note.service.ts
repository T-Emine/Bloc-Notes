import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { Note } from './note';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable()
export class NoteService {
  private noteUrl = 'http://localhost/my-project/public/index.php/api/form/get';   
  private noteDelUrl = 'http://localhost/my-project/public/index.php/api/form/delete';   
  private notePutUrl = 'http://localhost/my-project/public/index.php/api/form/put';
  private noteUrlID = 'http://localhost/my-project/public/index.php/api/form/getID'; 
  private noteUrlAdd = 'http://localhost/my-project/public/index.php/api/form/post';   

  constructor(
    private http: HttpClient){}

  getNote(): Observable<Note[]> {
    return this.http.get<Note[]>(this.noteUrl);
  }

  deleteNote (note: Note | number): Observable<Note> {
    const id = typeof note === 'number' ? note : note.id;
    const url = `${this.noteDelUrl}/${id}`;
  
    return this.http.delete<Note>(url, httpOptions);
  }

  saveNote(note: Note): Observable<any> {
    console.log(note);
    return this.http.put(this.notePutUrl, note, httpOptions);
  }

  getNoteID(id: number): Observable<Note> {
    const url = `${this.noteUrlID}/${id}`;
    return this.http.get<Note>(url, httpOptions);
  }

    //POST
  addNote (note: Note): Observable<Note> {
    console.log(note);
    return this.http.post<Note>(this.noteUrlAdd, note, httpOptions);
  }
}
