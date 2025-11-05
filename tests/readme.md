# Author
**Costel Nicolae**

# Notes
- 
- Laravel 11/12 style (no Kernel file – schedule defined in `routes/console.php`)
- Tickets use a factory to generate dummy data
- `status` is stored as boolean

# Tickets Challenge

This is a small Laravel project built for a coding assessment.  
It creates support tickets, processes them, and provides simple API endpoints.

# Features

- Creates dummy tickets from a console command
- Processes the oldest unprocessed ticket
- Simple ticket stats endpoint
- Basic REST endpoints for viewing tickets

---

## Console Commands

- generate ticket
- generate ticket processed

# Commands are scheduled in:

routes/console.php

Schedule::command('tickets:generate')->everyMinute();
Schedule::command('tickets:process')->everyFiveMinutes();

# ENDPOINTS

Method | Endpoint | Description |

| GET | `/tickets` | List all tickets |
| GET | `/tickets/open` | Unprocessed tickets |
| GET | `/tickets/closed` | Processed tickets |
| GET | `/users/{user_email}/ticketc` | Tickets by user email |
| GET | `/stats` | Ticket statistics |

# QLite in-memory database is used for tests.
