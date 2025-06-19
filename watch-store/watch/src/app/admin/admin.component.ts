import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { WatchService } from '../services/watch.service';
import { Watch } from '../models/watch';

@Component({
  selector: 'app-admin',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './admin.component.html',
  styleUrl: './admin.component.css'
})
export class AdminComponent implements OnInit {
  watches: Watch[] = [];
  showForm = false;
  isEditing = false;
  selectedWatch: Watch | null = null;

  watchFormData: Watch = {
    name: '',
    brand: '',
    price: 0,
    image: '',
    description: ''
  };

  constructor(private watchService: WatchService) {}

  ngOnInit(): void {
    this.loadWatches();
  }

  loadWatches(): void {
    this.watchService.getWatches().subscribe(watches => {
      this.watches = watches;
    });
  }

  showAddForm(): void {
    this.resetForm();
    this.isEditing = false;
    this.showForm = true;
  }

  editWatch(watch: Watch): void {
    this.watchFormData = { ...watch };
    this.selectedWatch = watch;
    this.isEditing = true;
    this.showForm = true;
  }

  deleteWatch(watch: Watch): void {
    if (confirm(`Are you sure you want to delete "${watch.name}"?`)) {
      this.watchService.deleteWatch(watch.id!).subscribe(() => {
        this.loadWatches();
      });
    }
  }

  onSubmit(): void {
    if (this.isEditing) {
      this.watchService.updateWatch(this.watchFormData).subscribe(() => {
        this.loadWatches();
        this.cancelForm();
      });
    } else {
      this.watchService.addWatch(this.watchFormData).subscribe(() => {
        this.loadWatches();
        this.cancelForm();
      });
    }
  }

  cancelForm(): void {
    this.showForm = false;
    this.resetForm();
  }

  resetForm(): void {
    this.watchFormData = {
      name: '',
      brand: '',
      price: 0,
      image: '',
      description: ''
    };
    this.selectedWatch = null;
    this.isEditing = false;
  }
}

