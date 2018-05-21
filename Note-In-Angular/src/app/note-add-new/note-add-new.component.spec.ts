import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NoteAddNewComponent } from './note-add-new.component';

describe('NoteAddNewComponent', () => {
  let component: NoteAddNewComponent;
  let fixture: ComponentFixture<NoteAddNewComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NoteAddNewComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NoteAddNewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
