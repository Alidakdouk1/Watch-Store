import { Component, Input, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Watch } from '../models/watch';

@Component({
  selector: 'app-watch-card',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './watch-card.component.html',
  styleUrl: './watch-card.component.css'
})
export class WatchCardComponent {
  @Input() watch!: Watch;
  @Output() buyClicked = new EventEmitter<Watch>();

  onBuyClick(): void {
    this.buyClicked.emit(this.watch);
  }
}

