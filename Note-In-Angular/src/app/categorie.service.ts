import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { Categorie } from './categorie';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};
  
@Injectable()
export class CategorieService {
  private catUrl = 'http://localhost/my-project/public/index.php/api/cat/get';   
  private catDelUrl = 'http://localhost/my-project/public/index.php/api/cat/delete';   
  private catPutUrl = 'http://localhost/my-project/public/index.php/api/cat/put';
  private catUrlID = 'http://localhost/my-project/public/index.php/api/cat/getID';   
  private catUrlAdd = 'http://localhost/my-project/public/index.php/api/cat/post';   

  constructor(
    private http: HttpClient){}

  getCategorie(): Observable<Categorie[]> {
    return this.http.get<Categorie[]>(this.catUrl)
  }

  deleteCat(cat: Categorie | number): Observable<Categorie> {
    const id = typeof cat === 'number' ? cat : cat.id;
    const url = `${this.catDelUrl}/${id}`;
  
    return this.http.delete<Categorie>(url, httpOptions)
  }

  //PUT
  saveCat(cat: Categorie): Observable<any> {
    return this.http.put(this.catPutUrl, cat, httpOptions)
  }

  getCategorieID(id: number): Observable<Categorie> {
    const url = `${this.catUrlID}/${id}`;
    return this.http.get<Categorie>(url, httpOptions)
  }

  //POST
  addCat (cat: string): Observable<Categorie> {
    return this.http.post<Categorie>(this.catUrlAdd, cat, httpOptions)
  }
 

}
