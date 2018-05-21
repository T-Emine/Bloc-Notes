import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule }    from '@angular/forms';
import { HttpClientModule }    from '@angular/common/http';
import { AppComponent } from './app.component';
import { RouterModule, Routes } from "@angular/router";
import { routes  } from './app.routes';
import { NoteComponent } from './note/note.component';
import { NoteService } from './note.service';
import { CategorieService } from './categorie.service';
import { CategorieComponent } from './categorie/categorie.component';
import { CategorieDetailComponent } from './categorie-detail/categorie-detail.component';
import { NoteDetailComponent } from './note-detail/note-detail.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { CategorieAddNewComponent } from './categorie-add-new/categorie-add-new.component';
import { NoteAddNewComponent } from './note-add-new/note-add-new.component';
  
@NgModule({
  declarations: [
    AppComponent,
    NoteComponent,
    CategorieComponent,
    CategorieDetailComponent,
    NoteDetailComponent,
    CategorieAddNewComponent,
    NoteAddNewComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,  
    HttpClientModule,
    NgbModule.forRoot(),
    RouterModule.forRoot(routes)
  ],
  providers: [NoteService, CategorieService],
  bootstrap: [AppComponent]
})
export class AppModule { }
