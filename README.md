<p align="center">
  <img src="https://github.com/PeiKang719/LoyalPaws/blob/main/media/lp.png" style="width:50%; height:15%;"/>
</p>

# LOYAL PAWS - Pet Adoption and Clinic Management System

## Description

**Loyal Paws** is a web-based platform designed to streamline the pet adoption process. It aims to enhance the efficiency of managing pet profiles, recording adoption transactions, and facilitating user interactions. Developed using *PHP* and *MySQL*, this system promotes responsible pet ownership by providing a user-friendly interface for both adopters and adoption agencies.

## Features

- **Pet Profiles Management**: Create and manage detailed pet profiles.
- **Adoption Applications**: Explore pet profiles and submit adoption applications online.
- **Data Management**: Transition from paper-based systems to a secure digital platform.
- **User Interaction**: Facilitate communication and transactions between adopters and agencies.
- **Reporting Capabilities**: Generate reports to understand user preferences.
- **Clinic Management**: Manage veterinary clinics and appointments.
- **Payment and Donation System**: Handle financial transactions securely using PayPal sandbox.

## Installation

To set up the project locally, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/PeiKang719/LoyalPaws.git

2. **Install XAMPP:**
   Download and install XAMPP.

3. **Move the project to the htdocs folder:**
   Move the cloned project folder to the htdocs directory of your XAMPP installation.

4. **Start Apache and MySQL:**
   Open the XAMPP Control Panel and start the Apache and MySQL services.

5. **Create a database:**
   Open your web browser and go to http://localhost/phpmyadmin.
   Create a new database named 'loyalpaws'.

6. **Import the database schema:**
   Import the provided 'loyalpaws.sql' file into the newly created database.

7. **Access the application:**
   Open your web browser and go to http://localhost/LoyalPaws.

## Usage

### Admin
- Manage user roles, breed profiles, organization profiles, and view reports. <br />

### Adopter
- Register, browse pets, apply for adoption, breed matching, make donation, book clinic appointment, and manage profiles. <br />

### Clinic and Veterinarian
- Manage clinic appointments, pet medical records, and view reports. Clinic Admins can also specify the discount percentage exclusively for adopters. <br />

### Payment Processing

![Paypal Logo](https://github.com/PeiKang719/LoyalPaws/blob/main/media/sandbox.png)

- The payment system uses PayPal Sandbox for handling financial transactions securely.
   - Ensure you have a PayPal Sandbox account set up.
   - Configure the PayPal Sandbox credentials in the payment settings of the application.
   - PayPal Sandbox Credentials (for testing purposes):
      - Email: *sb-wp2cq25985524@personal.example.com*
      - Password: *123456789*
      




   





   






