# Sylcroad Campaign Management Platform

A modern, professional web application for campaign management with a clean baby blue UI theme.

## Project Structure

```
sylcroad-live/
├── src/
│   ├── pages/
│   │   ├── Login.jsx          # Login page component
│   │   ├── Login.css          # Login page styles
│   │   ├── Dashboard.jsx      # Dashboard component
│   │   └── Dashboard.css      # Dashboard styles
│   ├── styles/
│   │   └── global.css         # Global styles and CSS variables
│   ├── App.jsx                # Main app component with routing
│   └── main.jsx               # Entry point
├── package.json               # Project dependencies
├── vite.config.js             # Vite configuration
└── index-new.html             # HTML template
```

## Features

### Login Page
- Clean, modern login interface
- Email/password authentication
- Google Sign-In placeholder
- Loading states and error handling
- Responsive design

### Dashboard
- Sidebar navigation with organized sections
- Statistics cards showing key metrics
- Interactive charts (Campaign Performance & Audience Growth)
- Recent campaigns table with filters
- Fully responsive design
- Baby blue primary color scheme (#60a5fa)

## Setup Instructions

### 1. Install Dependencies
```bash
npm install
```

### 2. Development Server
```bash
npm run dev
```

The app will be available at `http://localhost:3000`

### 3. Build for Production
```bash
npm run build
```

Builds the app for production to the `dist` folder.

### 4. Preview Production Build
```bash
npm run preview
```

## Color Scheme

- **Primary Blue**: #60a5fa (Baby Blue)
- **Primary Blue Dark**: #3b82f6
- **Background**: #f8fafc
- **Card Background**: #ffffff
- **Text Primary**: #1a1a1a
- **Text Secondary**: #6b7280

## Tech Stack

- **React 18** - UI library
- **React Router DOM** - Client-side routing
- **Chart.js** - Data visualization
- **Vite** - Build tool and dev server
- **CSS3** - Styling with CSS variables

## Features

- ✅ Protected routes with authentication
- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Modern UI with smooth animations
- ✅ Interactive charts and data visualization
- ✅ Professional component structure
- ✅ Baby blue color theme throughout

## API Integration

The app expects authentication endpoints at:
- `POST /api/auth/login` - Login endpoint

Make sure your backend API is configured to handle these requests.

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Next Steps

1. Configure your backend API endpoints
2. Add environment variables for API URLs
3. Implement additional pages (Campaigns, Audience, Analytics, etc.)
4. Add form validation libraries if needed
5. Implement state management (Redux, Zustand, etc.) if needed for larger scale

## Notes

- The old standalone HTML files (`login.html`, `dashboard.html`) can be removed once the React app is deployed
- Replace `index.html` with `index-new.html` for the new React application
- Make sure to update your web server configuration to serve the React app properly
