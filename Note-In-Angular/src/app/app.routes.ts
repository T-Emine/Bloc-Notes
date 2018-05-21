import { RouterModule, Routes } from '@angular/router';
import { NgModule } from '@angular/core';
import { NoteComponent } from './note/note.component';
import { CategorieComponent } from './categorie/categorie.component';
import { CategorieDetailComponent } from './categorie-detail/categorie-detail.component';
import { NoteDetailComponent } from './note-detail/note-detail.component';
import { CategorieAddNewComponent } from './categorie-add-new/categorie-add-new.component';
import { NoteAddNewComponent } from './note-add-new/note-add-new.component';

export const routes: Routes = [
    { path: '', redirectTo: 'home', pathMatch: 'full'},
    { path: 'note', component: NoteComponent },
    { path: 'cat', component: CategorieComponent },
    { path: 'detailCat/:id', component: CategorieDetailComponent },
    { path: 'detailNote/:id', component: NoteDetailComponent },
    { path: 'catAdd', component: CategorieAddNewComponent },
    { path: 'noteAdd', component: NoteAddNewComponent }
];
    