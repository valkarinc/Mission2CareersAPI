# Mission2CareersAPI

> **A systematic API system that grabs and communicates with top-notch job search queries**

This repository houses the backend API logic for **Mission2Career**, a platform designed to bridge the gap between military service and civilian employment. It serves as a systematic interface for querying, filtering, and managing job data from the Supabase database.

## 🚀 Features

* **Systematic Query Communication:** efficiently grabs and processes job search queries with precision.
* **Supabase Connector:** A lightweight PHP wrapper interacting directly with the Supabase REST API (no heavy frameworks required).
* **Top-Notch Job Filtering:** Supports complex queries including:
    * **Keywords:** Title, Skills, and MOS codes.
    * **Location:** City, State, and "Remote" logic.
    * **Attributes:** Veteran-friendly status, job type (Full-time/Contract), and recency.
* **Secure & Scalable:** Built with secure header management for API keys and scalable architecture.

## 🛠️ Installation

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/yourusername/mission2careers-api.git](https://github.com/yourusername/mission2careers-api.git)
    ```

2.  **Configure Environment:**
    Navigate to `includes/db.php` and configure your Supabase credentials:
    ```php
    define('SUPABASE_URL', '[https://your-project-ref.supabase.co](https://your-project-ref.supabase.co)');
    define('SUPABASE_KEY', 'your-public-anon-key');
    ```

## 📖 Usage

### Initialization
The system uses a singleton-style connector to manage state and connection pooling.

```php
require_once 'includes/db.php';
$api = new Supabase();
Grabbing Job Queries
Execute systematic searches using the fluent array-based syntax:

PHP

// Example: Find 'Cybersecurity' roles in 'Virginia'
$params = [
    'select'   => '*',
    'title'    => 'ilike.*Cybersecurity*',
    'location' => 'ilike.*Virginia*',
    'order'    => 'posted_date.desc'
];

$results = $api->get('jobs', $params);
```
## 📂 Directory Structure
includes/ - Core database connectors and authentication logic.

endpoints/ - API entry points for frontend communication.

services/ - Data transformation and external API integration.

🤝 Contributing
Contributions are welcome! Please fork the repository and submit a pull request for any enhancements to the query system.

📄 License
Distributed under the MIT License.
