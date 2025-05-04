# 3D Web Application
This interactive web application showcases 3D drink models using a custom MVC framework built with PHP, JavaScript, and Three.js. 
Users can view, rotate, animate, and swap between different models, explore gallery images, and toggle dark mode.

You can view this application here: https://users.sussex.ac.uk/~cm2013/Web-3D/Web-3D/index.php#

![image](https://github.com/user-attachments/assets/4e02f6a7-3950-4fde-8aaf-f5b1374fdcda)

## Features:
- 3D model rendering with Three.js and GLTFLoader
- Brand-based model cycling with sound effects
- Dynamic content switching (SPA-style)
- Gallery viewer with modal previews
- Lighting and material control via dat.GUI
- Dark mode toggle
- MVC structure (Controller, Model, View separation)

## Technologies Used:
- PHP (MVC backend logic)
- JavaScript (DOM interaction, async APIs)
- Three.js (3D rendering)
- Bootstrap 5 (UI and layout)
- jQuery (gallery rendering)
- SQLite (data storage)

## Setup Instructions:
- Clone the project or download the ZIP.
- Place the project inside your web server's root (e.g., htdocs for XAMPP).
- Ensure test.db exists under /db with correct read/write permissions.
- Access via: http://localhost/your-folder/index.php

Reset the database:  
Call these routes in the browser to reset data:  
  ?route=apiCreateTable  
  ?route=apiInsertData

## Licence
This project is for academic and coursework purposes only. Not intended for commercial distribution.
