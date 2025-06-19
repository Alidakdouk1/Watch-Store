# Watch Store App - Angular 19 Project

A modern watch store application built with a PHP backend, featuring a clean UI and complete CRUD functionality.

## 🚀 Features

### Frontend (Angular 19)
- **Home Page**: Browse all available watches in a responsive grid layout
- **Watch Cards**: Beautiful product cards with hover effects
- **Buy Form**: Modal form for customer orders with validation
- **Admin Panel**: Complete CRUD operations for watch management
- **Responsive Design**: Mobile-friendly layout
- **Modern UI**: Professional styling with gradients and animations

### Backend (PHP)
- **RESTful API**: Complete CRUD operations
- **MySQL Database**: Structured data storage
- **Order Management**: Customer order processing
- **CORS Support**: Configured for Angular frontend
- **Input Validation**: Security and data integrity

### Key Angular Concepts Used (from PDF)
- **Components**: Modular, reusable UI components
- **Data Binding**: 
  - String interpolation `{{ }}`
  - Property binding `[property]`
  - Event binding `(event)`
  - Two-way binding `[(ngModel)]`
- **Directives**: 
  - `*ngFor` for displaying watch lists
  - `*ngIf` for conditional rendering
  - `[class]` for dynamic styling
- **Services**: Centralized data management
- **Routing**: Navigation between pages
- **Forms**: Template-driven forms with validation
- **Pipes**: Data transformation (currency, number formatting)

## 📁 Project Structure

```
watch-store-app/
├── src/
│   ├── app/
│   │   ├── admin/              # Admin component (CRUD)
│   │   ├── home/               # Home component (display watches)
│   │   ├── watch-card/         # Watch card component
│   │   ├── buy-form/           # Buy form component
│   │   ├── models/             # TypeScript interfaces
│   │   ├── services/           # Angular services
│   │   └── assets/
│   │       └── images/         # Local watch images
│   └── ...
├── backend/
│   ├── api/                    # PHP API endpoints
│   ├── config/                 # Database and models
│   └── setup.php              # Database initialization
└── ...
```

## 🛠️ Setup Instructions

### Prerequisites
- Node.js (v18 or higher)
- Angular CLI (`npm install -g @angular/cli`)
- PHP (v7.4 or higher)
- MySQL
- Web server (Apache/Nginx)

### Frontend Setup
1. Navigate to project directory
2. Install dependencies: `npm install`
3. Start development server: `ng serve`
4. Open browser to `http://localhost:4200`

### Backend Setup
1. Create MySQL database named `watch_store`
2. Update database credentials in `backend/config/database.php`
3. Place `backend` folder in your web server directory
4. Run setup script: `php backend/setup.php`
5. Ensure API is accessible at `http://localhost/api/`

### Image Assets
The project includes local images stored in `src/assets/images/`:
- `rolex-submariner.jpg`
- `omega-speedmaster.jpg`
- `tag-heuer-formula1.jpg`
- `seiko-prospex.jpg`

## 🎯 Usage

### Customer Features
- Browse watches on the home page
- Click "Buy Now" to open purchase form
- Fill out customer details (name, email, phone, address)
- Submit order (data logged as JSON)

### Admin Features
- Access admin panel via navigation
- Add new watches with details and image paths
- Edit existing watch information
- Delete watches from inventory
- View all watches in table format

## 🔧 API Endpoints

- `GET /api/watches.php` - Get all watches
- `POST /api/add-watch.php` - Add new watch
- `PUT /api/update-watch.php` - Update watch
- `DELETE /api/delete-watch.php?id={id}` - Delete watch
- `POST /api/buy.php` - Submit order

## 📱 Responsive Design

The application is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones

## 🎨 Styling

- Modern gradient backgrounds
- Smooth hover animations
- Professional color scheme
- Bootstrap-inspired grid system
- Custom CSS with CSS variables

## 🔒 Security Features

- Input sanitization
- SQL injection prevention
- CORS configuration
- Form validation (frontend and backend)

## 📊 Order Data Format

When a customer places an order, the data is logged in JSON format:

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "address": "123 Main St, City, State",
  "watch": {
    "id": 1,
    "name": "Rolex Submariner",
    "price": 8500
  },
  "orderDate": "2025-01-01T12:00:00.000Z",
  "total": 8500
}
```

## 🚀 Deployment

For production deployment:
1. Build Angular app: `ng build --prod`
2. Deploy `dist/` folder to web server
3. Configure PHP backend with production database
4. Update API URLs in Angular service
5. Set up SSL certificates for HTTPS

## 📝 Notes

- The project uses Angular 19 standalone components (no app.module.ts)
- Sample data is included for development
- Images are stored locally in the assets folder
- Form data is logged to console for development purposes

Enjoy building with this modern Angular watch store application! 🕰️

