# Project Documentation

## Overview

This project uses Docker and Docker Compose to manage the environment and workflow. Below are the available Makefile
commands to handle the typical operations for the project.

---

## Prerequisites

Before using the Makefile, ensure the following are installed and configured on your system:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Make](https://www.gnu.org/software/make/)

---

## Usage

Use the provided `Makefile` to manage Docker containers and perform actions like building the application and executing commands within the containerized environment.


---

## Quick Start

Follow these steps to quickly set up and run the project:

1. **Build Docker images**
   ```bash
   make build
   ```

2. **Start Docker containers**
   ```bash
   make up
   ```

3. **Install Composer dependencies**
   ```bash
   make composer args="install"
   ```

4. **Install node dependencies**
   ```bash
   make npm args="install"
   make npm args="build"
   ```
   
5. **Set file and directory permissions**
   ```bash
   chown -R user:user app/
   chmod -R 755 database/
   chmod -R 755 storage/
   ```

6. **Run database migrations if needed**
   ```bash
   make artisan args="migrate"
   ```
7. **Open app in browser**
   ```bash
   http://localhost
   ```

### Commands

- **Build Docker images**
  ```bash
  make build
  ```
  Build the Docker images defined in the `docker-compose.yml` file.

- **Start Docker containers**
  ```bash
  make up
  ```
  Start the Docker containers in detached mode.

- **Stop Docker containers**
  ```bash
  make down
  ```
  Stop and remove the Docker containers.

- **Run Composer inside the container**
  ```bash
  make composer args="your-composer-command"
  ```
  Example:
  ```bash
  make composer args="install"
  ```
  Runs Composer commands using the `nginx` container.

- **Run Laravel Artisan commands**
  ```bash
  make artisan args="your-artisan-command"
  ```
  Example:
  ```bash
  make artisan args="migrate"
  ```
  Executes Laravel Artisan commands using the `nginx` container.

- **Open a shell in the Nginx container**
  ```bash
  make shell
  ```
  Opens an interactive shell session in the `nginx` container under `/var/www/html`

---
## Notes

- The `args` option is used to pass additional arguments for the `composer` and `artisan` commands. Replace
  `"your-command"` with the appropriate subcommand or options for these tools.
- Ensure that `docker-compose.yml` is properly configured to match the project's structure.

---

## Troubleshooting

- If the Docker containers fail to start, check the logs using:
  ```bash
  docker logs nginx
  ```
- Ensure Docker and Docker Compose services are running before using the `Makefile` commands.

---

### **NPI Registry Search Application**

This application provides a user-friendly interface built with **Laravel 12.2** and **Livewire 3.6.2** to search and retrieve healthcare provider information from the **National Provider Identifier (NPI) Registry**.

---

## **Features**

✅ **Comprehensive Search**: Users can search providers by:
- First Name
- Last Name
- NPI Number
- Taxonomy Description
- City
- State
- Zip Code

✅ **Pagination**: Displays **5 providers per page** for easy navigation.

✅ **Detailed Provider Information**: Clicking on a provider displays a **modal** with extensive details from the NPI registry.

✅ **Modern UI**: Built using **Laravel, Livewire, Tailwind CSS, and Alpine.js** for a responsive and intuitive experience.

---

## **Technology Stack**

- **Docker**
- **Nginx**
- **Laravel 12.2**
- **Livewire 3.6.2**
- **Tailwind CSS**
---

## **How It Works**

🔹 The frontend uses Livewire for interactive searches and displaying results.  
🔹 Search requests are processed by the **Laravel backend**, which interfaces with the official **NPI Registry API**.  
🔹 API responses are **parsed dynamically** and displayed, including detailed views via modals.

---

## **Directory Structure**

```
resources/views/components/layouts/app.blade.php
resources/views/livewire/npi-search.blade.php
app/Http/Livewire/NpiSearch.php
```