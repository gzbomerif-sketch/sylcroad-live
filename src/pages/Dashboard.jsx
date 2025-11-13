import { useState, useEffect, useRef } from 'react';
import { Chart, registerables } from 'chart.js';
import './Dashboard.css';

Chart.register(...registerables);

export default function Dashboard() {
  const [user, setUser] = useState(null);
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const performanceChartRef = useRef(null);
  const growthChartRef = useRef(null);
  const performanceChartInstance = useRef(null);
  const growthChartInstance = useRef(null);

  useEffect(() => {
    const userData = JSON.parse(localStorage.getItem('user') || '{"name": "John Doe", "email": "admin@sylcroad.com"}');
    setUser(userData);

    // Initialize charts
    if (performanceChartRef.current) {
      performanceChartInstance.current = new Chart(performanceChartRef.current, {
        type: 'line',
        data: {
          labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
          datasets: [{
            label: 'Campaigns Sent',
            data: [1200, 1900, 1500, 2100, 1800, 2400, 2200],
            borderColor: '#60a5fa',
            backgroundColor: 'rgba(96, 165, 250, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: '#f3f4f6'
              }
            },
            x: {
              grid: {
                display: false
              }
            }
          }
        }
      });
    }

    if (growthChartRef.current) {
      growthChartInstance.current = new Chart(growthChartRef.current, {
        type: 'bar',
        data: {
          labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
          datasets: [{
            label: 'New Subscribers',
            data: [650, 890, 750, 1100, 980, 1350, 1200],
            backgroundColor: '#60a5fa',
            borderRadius: 8,
            borderSkipped: false
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: '#f3f4f6'
              }
            },
            x: {
              grid: {
                display: false
              }
            }
          }
        }
      });
    }

    return () => {
      if (performanceChartInstance.current) performanceChartInstance.current.destroy();
      if (growthChartInstance.current) growthChartInstance.current.destroy();
    };
  }, []);

  const getInitials = (name) => {
    return name?.split(' ').map(n => n[0]).join('').toUpperCase() || 'JD';
  };

  const campaigns = [
    { name: 'Summer Sale 2024', type: 'email', status: 'active', sent: '12,450', openRate: '68.5%', clickRate: '12.3%', progress: 75 },
    { name: 'Product Launch', type: 'social', status: 'active', sent: '8,932', openRate: '72.1%', clickRate: '15.8%', progress: 90 },
    { name: 'Flash Sale Alert', type: 'sms', status: 'completed', sent: '25,601', openRate: '95.2%', clickRate: '28.4%', progress: 100 },
    { name: 'Newsletter May', type: 'email', status: 'paused', sent: '5,234', openRate: '61.7%', clickRate: '9.2%', progress: 45 },
    { name: 'Black Friday Preview', type: 'email', status: 'active', sent: '18,765', openRate: '74.3%', clickRate: '18.9%', progress: 82 },
  ];

  return (
    <div className="dashboard-layout">
      {/* Sidebar */}
      <aside className={`sidebar ${sidebarOpen ? 'open' : ''}`}>
        <div className="sidebar-header">
          <div className="logo-text">Sylcroad</div>
        </div>

        <nav className="nav-menu">
          <div className="nav-section">
            <div className="nav-section-title">Main</div>
            <a href="#" className="nav-item active">
              <span className="nav-item-icon">📊</span>
              Overview
            </a>
            <a href="#" className="nav-item">
              <span className="nav-item-icon">🚀</span>
              Campaigns
              <span className="nav-item-badge">12</span>
            </a>
            <a href="#" className="nav-item">
              <span className="nav-item-icon">👥</span>
              Audience
            </a>
            <a href="#" className="nav-item">
              <span className="nav-item-icon">📈</span>
              Analytics
            </a>
          </div>

          <div className="nav-section">
            <div className="nav-section-title">Content</div>
            <a href="#" className="nav-item">
              <span className="nav-item-icon">📧</span>
              Email Templates
            </a>
            <a href="#" className="nav-item">
              <span className="nav-item-icon">🎨</span>
              Assets
            </a>
            <a href="#" className="nav-item">
              <span className="nav-item-icon">📝</span>
              Content Library
            </a>
          </div>

          <div className="nav-section">
            <div className="nav-section-title">Settings</div>
            <a href="#" className="nav-item">
              <span className="nav-item-icon">⚙️</span>
              Settings
            </a>
            <a href="#" className="nav-item">
              <span className="nav-item-icon">👤</span>
              Team
            </a>
            <a href="#" className="nav-item">
              <span className="nav-item-icon">🔔</span>
              Notifications
            </a>
          </div>
        </nav>
      </aside>

      {/* Main Content */}
      <main className="main-content">
        {/* Top Header */}
        <header className="top-header">
          <button className="mobile-menu-btn" onClick={() => setSidebarOpen(!sidebarOpen)}>
            <span>☰</span>
          </button>

          <div className="search-bar">
            <span className="search-icon">🔍</span>
            <input type="text" placeholder="Search campaigns, contacts, or analytics..." />
          </div>

          <div className="header-actions">
            <button className="header-btn">
              <span>🔔</span>
              <span className="notification-badge"></span>
            </button>
            <button className="header-btn">
              <span>❓</span>
            </button>

            <div className="user-profile">
              <div className="user-avatar">{user && getInitials(user.name)}</div>
              <div className="user-info">
                <div className="user-name">{user?.name || 'John Doe'}</div>
                <div className="user-role">Admin</div>
              </div>
            </div>
          </div>
        </header>

        {/* Content Area */}
        <div className="content-area">
          {/* Page Header */}
          <div className="page-header">
            <h1 className="page-title">Overview</h1>
            <p className="page-subtitle">Welcome back! Here's what's happening with your campaigns today.</p>
          </div>

          {/* Stats Grid */}
          <div className="stats-grid">
            <div className="stat-card">
              <div className="stat-header">
                <span className="stat-label">Total Campaigns</span>
                <div className="stat-icon blue">🚀</div>
              </div>
              <div className="stat-value">1,247</div>
              <div className="stat-change positive">
                <span>↑</span>
                <span>12.5% from last month</span>
              </div>
            </div>

            <div className="stat-card">
              <div className="stat-header">
                <span className="stat-label">Active Users</span>
                <div className="stat-icon green">👥</div>
              </div>
              <div className="stat-value">45,892</div>
              <div className="stat-change positive">
                <span>↑</span>
                <span>8.2% from last month</span>
              </div>
            </div>
          </div>

          {/* Charts Grid */}
          <div className="charts-grid">
            <div className="chart-card">
              <div className="chart-header">
                <h3 className="chart-title">Campaign Performance</h3>
                <select className="chart-filter">
                  <option>Last 7 days</option>
                  <option>Last 30 days</option>
                  <option>Last 90 days</option>
                </select>
              </div>
              <canvas ref={performanceChartRef} height="200"></canvas>
            </div>

            <div className="chart-card">
              <div className="chart-header">
                <h3 className="chart-title">Audience Growth</h3>
                <select className="chart-filter">
                  <option>Last 7 days</option>
                  <option>Last 30 days</option>
                  <option>Last 90 days</option>
                </select>
              </div>
              <canvas ref={growthChartRef} height="200"></canvas>
            </div>
          </div>

          {/* Recent Campaigns Table */}
          <div className="table-card">
            <div className="table-header">
              <h3 className="table-title">Recent Campaigns</h3>
              <div className="table-actions">
                <button className="btn btn-secondary">
                  <span>📥</span>
                  Export
                </button>
                <button className="btn btn-primary">
                  <span>➕</span>
                  New Campaign
                </button>
              </div>
            </div>

            <div className="table-container">
              <table>
                <thead>
                  <tr>
                    <th>Campaign Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Sent</th>
                    <th>Open Rate</th>
                    <th>Click Rate</th>
                    <th>Progress</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  {campaigns.map((campaign, index) => (
                    <tr key={index}>
                      <td className="campaign-name">{campaign.name}</td>
                      <td>
                        <span className={`campaign-type ${campaign.type}`}>
                          {campaign.type.charAt(0).toUpperCase() + campaign.type.slice(1)}
                        </span>
                      </td>
                      <td>
                        <span className={`status-badge ${campaign.status}`}>
                          <span className="status-dot"></span>
                          {campaign.status.charAt(0).toUpperCase() + campaign.status.slice(1)}
                        </span>
                      </td>
                      <td>{campaign.sent}</td>
                      <td>{campaign.openRate}</td>
                      <td>{campaign.clickRate}</td>
                      <td>
                        <div className="progress-bar-container">
                          <div className="progress-bar" style={{ width: `${campaign.progress}%` }}></div>
                        </div>
                      </td>
                      <td>
                        <div className="action-buttons">
                          <button className="icon-btn" title="View">👁️</button>
                          <button className="icon-btn" title="Edit">✏️</button>
                          <button className="icon-btn" title="Delete">🗑️</button>
                        </div>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
}
