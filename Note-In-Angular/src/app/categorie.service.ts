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

 /*
  * Méthode pour récupérer la liste de catégorie via l'API REST
  */ 
  getCategorie(): Observable<Categorie[]> {
    return this.http.get<Categorie[]>(this.catUrl)
  }

 /*
  * Méthode pour supprimer une catégorie via l'API REST
  */
  deleteCat(cat: Categorie | number): Observable<Categorie> {
    const id = typeof cat === 'number' ? cat : cat.id;
    const url = `${this.catDelUrl}/${id}`;
  
    return this.http.delete<Categorie>(url, httpOptions)
  }

  /*
  * PUT
  * Méthode pour enregistrer les modification d'une catégorie via l'API REST
  */
  saveCat(cat: Categorie): Observable<any> {
    return this.http.put(this.catPutUrl, cat, httpOptions)
  }

/*
  * Méthode pour récupérer une catégorie qui est modifié (on a que son id d'où
  * le fait que l'on n'utilise pas l'autre méthode get)
  */
  getCategorieID(id: number): Observable<Categorie> {
    const url = `${this.catUrlID}/${id}`;
    return this.http.get<Categorie>(url, httpOptions)
  }

 /*
  * POST
  * Méthode pour ajouter une nouvelle catégorie via l'API REST
  */
  addCat (cat: string): Observable<Categorie> {
    return this.http.post<Categorie>(this.catUrlAdd, cat, httpOptions)
  }
 

}
