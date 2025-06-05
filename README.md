#  Pulmonology Clinic Website

A dynamic and informative web application created as part of a professional practice project, designed for a Pulmonology Clinic. This platform serves both as an informative site for patients and a management system for clinic administrators.

---

##  Project Description

This web-based system provides patients with the ability to:
- Learn about the clinic and its medical staff.
- Register and log into their account.
- Book, view, or cancel medical appointments.

Meanwhile, administrators can:
- Manage doctors, patients, and appointments.
- Approve, confirm, or cancel appointment requests.
- View statistics through a dashboard.
- Enable or disable patient accounts.

The platform simulates real-world clinic workflows, including:
- Appointment hours restricted from 07:00 to 20:00.
- No appointments allowed on Sundays.
- Password validation with minimum security standards.

---

##  User Roles

- **Admin:** Full access to manage doctors, view patients, control appointment status, and deactivate accounts.
- **Patient:** Can request appointments, view personal history, and interact with the clinic team via the contact form.

---

##  Key Features

###  Authentication & User Management
- Patient registration and login
- Admin login
- Password validation (length, uppercase, number)
- Session-based access control
- Account activation/deactivation by admin

###  Appointments
- Book appointment with doctor (date/time restrictions)
- Dynamic doctor selection
- View and cancel personal appointments
- Admin manages all appointment statuses

###  Doctor Management (Admin Panel)
- Add, edit, delete doctors (with photo)
- Doctors listed on public-facing site
- Modal preview and appointment shortcut

###  Admin Dashboard
- Total doctors, patients, appointments
- Visual layout with quick navigation buttons

###  Public Interface
- Responsive Bootstrap 5 layout
- Informative pages (About, Staff, Contact)
- Accessible contact form (email logic tested with Mailtrap)

---

##  Contact Form & Mailtrap Integration

The contact form allows visitors to send inquiries. Email delivery is sandboxed using [Mailtrap.io](https://mailtrap.io), providing:

- Safe email testing environment
- SMTP simulation for development
- Easy preview of email content and headers

---

## 🛠 Technologies Used

- PHP (backend)
- MySQL (database)
- HTML5 & CSS3 (structure and layout)
- Bootstrap 5 (responsive design)
- JavaScript (basic validation)
- Mailtrap (email testing)

---

Developed by: Erëza Temaj
