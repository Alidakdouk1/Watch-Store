import { Component, Input, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Watch } from '../models/watch';
import { WatchService } from '../services/watch.service';

@Component({
  selector: 'app-buy-form',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './buy-form.component.html',
  styleUrl: './buy-form.component.css'
})
export class BuyFormComponent {
  @Input() selectedWatch: Watch | null = null;
  @Output() formClosed = new EventEmitter<void>();
  @Output() orderSubmitted = new EventEmitter<any>();

  orderForm = {
    name: '',
    email: '',
    phone: '',
    address: ''
  };

  submitMessage = '';

  constructor(private watchService: WatchService) {}

  onSubmit(): void {
    const orderData = {
      ...this.orderForm,
      watch: this.selectedWatch,
      orderDate: new Date().toISOString(),
      total: this.selectedWatch?.price
    };

    this.watchService.buyWatch(orderData).subscribe({
      next: (response) => {
        this.submitMessage = 'Order submitted successfully!';
        this.orderSubmitted.emit(orderData);
        setTimeout(() => {
          this.onClose();
        }, 2000);
      },
      error: (error) => {
        this.submitMessage = 'Error submitting order. Please try again.';
      }
    });
  }

  onClose(): void {
    this.orderForm = { name: '', email: '', phone: '', address: '' };
    this.submitMessage = '';
    this.formClosed.emit();
  }
}

