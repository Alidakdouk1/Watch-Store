import { ComponentFixture, TestBed } from '@angular/core/testing';

import { WatchCard } from './watch-card';

describe('WatchCard', () => {
  let component: WatchCard;
  let fixture: ComponentFixture<WatchCard>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [WatchCard]
    })
    .compileComponents();

    fixture = TestBed.createComponent(WatchCard);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
