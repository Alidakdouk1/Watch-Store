import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { WatchCardComponent } from '../watch-card/watch-card.component';
import { BuyFormComponent } from '../buy-form/buy-form.component';
import { WatchService } from '../services/watch.service';
import { Watch } from '../models/watch';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [CommonModule, WatchCardComponent, BuyFormComponent],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent implements OnInit {
  watches: Watch[] = [];
  selectedWatch: Watch | null = null;

  constructor(private watchService: WatchService) {}

  ngOnInit(): void {
    this.loadWatches();
  }

  loadWatches(): void {
    this.watchService.getWatches().subscribe(watches => {
      this.watches = watches;
    });
  }

  onBuyWatch(watch: Watch): void {
    this.selectedWatch = watch;
  }

  onCloseBuyForm(): void {
    this.selectedWatch = null;
  }

  onOrderSubmitted(orderData: any): void {
    console.log('Order data (JSON):', JSON.stringify(orderData, null, 2));
    this.selectedWatch = null;
  }
}

