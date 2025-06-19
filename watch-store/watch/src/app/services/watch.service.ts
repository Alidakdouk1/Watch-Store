import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of, BehaviorSubject } from 'rxjs';
import { Watch } from '../models/watch';

@Injectable({
  providedIn: 'root'
})
export class WatchService {
  private apiUrl = 'http://localhost/api';

  // Sample data with local images
  private sampleWatches: Watch[] = [
    {
      id: 1,
      name: 'Rolex Submariner',
      price: 8500,
      image: 'assets/images/rolex-submariner.jpg',
      description: 'Luxury diving watch with automatic movement',
      brand: 'Rolex'
    },
    {
      id: 2,
      name: 'Omega Speedmaster',
      price: 5200,
      image: 'assets/images/omega-speedmaster.jpg',
      description: 'Professional chronograph watch',
      brand: 'Omega'
    },
    {
      id: 3,
      name: 'TAG Heuer Formula 1',
      price: 1200,
      image: 'assets/images/tag-heuer-formula1.jpg',
      description: 'Sports watch with precision timing',
      brand: 'TAG Heuer'
    },
    {
      id: 4,
      name: 'Seiko Prospex',
      price: 350,
      image: 'assets/images/seiko-prospex.jpg',
      description: 'Reliable diving watch for professionals',
      brand: 'Seiko'
    }
  ];

  // BehaviorSubject to maintain state and notify components of changes
  private watchesSubject = new BehaviorSubject<Watch[]>(this.sampleWatches);
  public watches$ = this.watchesSubject.asObservable();

  constructor(private http: HttpClient) { }

  // Get all watches
  getWatches(): Observable<Watch[]> {
    return this.watches$;
    // For production: return this.http.get<Watch[]>(`${this.apiUrl}/watches.php`);
  }

  // Add new watch
  addWatch(watch: Watch): Observable<Watch> {
    const newWatch = { ...watch, id: Date.now() };
    this.sampleWatches.push(newWatch);
    this.watchesSubject.next([...this.sampleWatches]);
    return of(newWatch);
    // For production: return this.http.post<Watch>(`${this.apiUrl}/add-watch.php`, watch);
  }

  // Update watch
  updateWatch(watch: Watch): Observable<Watch> {
    const index = this.sampleWatches.findIndex(w => w.id === watch.id);
    if (index !== -1) {
      this.sampleWatches[index] = watch;
      this.watchesSubject.next([...this.sampleWatches]);
    }
    return of(watch);
    // For production: return this.http.put<Watch>(`${this.apiUrl}/update-watch.php`, watch);
  }

  // Delete watch
  deleteWatch(id: number): Observable<boolean> {
    const index = this.sampleWatches.findIndex(w => w.id === id);
    if (index !== -1) {
      this.sampleWatches.splice(index, 1);
      this.watchesSubject.next([...this.sampleWatches]);
      return of(true);
    }
    return of(false);
    // For production: return this.http.delete<boolean>(`${this.apiUrl}/delete-watch.php?id=${id}`);
  }

  // Submit buy order
  buyWatch(orderData: any): Observable<any> {
    console.log('Order submitted:', orderData);
    return of({ success: true, message: 'Order submitted successfully!' });
    // For production: return this.http.post(`${this.apiUrl}/buy.php`, orderData);
  }
}

