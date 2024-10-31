# Art Gallery Web Platform

A Symfony-powered e-commerce platform for an art gallery to showcase and sell artworks with secure online payments, and an admin interface for managing artists and artwork.

## Features

- **Artwork & Artist Management**: Admins can add, edit, and delete artworks and artist profiles.
- **Customer Registration & Authentication**: Visitors can register to become clients and securely log in.
- **Browsing & Search**: Clients can search for artists by name or browse artworks by artist or category.
- **Voting System**: Clients can vote for their favorite artworks and artists.
- **Secure Payment**: Integrated with "chaimoinscheir" for secure online payments.
- **Daily Backup**: A super-administrator triggers a daily gallery backup.
- **Invoice Requests**: Clients can request invoices for past purchases via phone.

## Technology Stack

- **Backend**: Symfony
- **Database**: MySQL (or other databases supported by Doctrine ORM)
- **Payment Integration**: Chaimoinscheir Payment Gateway

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/ayoubmek/Galegie_d-art.git
   cd Galegie_d-art
2. Install dependencies:
   ```bash
   composer install
   
4. Set up environment variables:
   ```bash
   cp .env .env.local
   
6. Run database migrations:
   ```bash
   php bin/console doctrine:migrations:migrate

8. Start the Symfony server:
   ```bash
   symfony serve


