import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CategorieAddNewComponent } from './categorie-add-new.component';

describe('CategorieAddNewComponent', () => {
  let component: CategorieAddNewComponent;
  let fixture: ComponentFixture<CategorieAddNewComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CategorieAddNewComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CategorieAddNewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
