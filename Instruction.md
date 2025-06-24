A Portfolio & Project Showcase App   

🎯 Project Objective:
Build a full-featured user-driven portfolio platform where developers (like
yourself) can showcase their skills, upload projects, and share links or GitHub
repositories.

🔧 Core Features
1. Frontend Features (Vue + Tailwind – Heavy Focus) 🔹
• Beautiful responsive UI using Tailwind CSS
• SPA-like UX using Vue.js
• Interactive project cards with image preview
• Modal form to Add / Edit Projects
• Client-side form validation
• Toasts for success/error messages
2. Authentication 🔹
• User registration/login/logout using Laravel Breeze/Jetstream (Inertia or API
based)
• Auth middleware to restrict dashboard & actions
3. Project Management 🔹
• Add/Edit/Delete portfolio projects
• Each project includes:
• Title, description
• Tags (e.g., Laravel, Vue, Tailwind)
• GitHub/Live link
• Thumbnail image
• Visibility (public/private)

• Select Project Category (Frontend, Backend, Database)
• Progress % (Show with Tailwind progress bars when viewed)
4. Public Profile Page 🔹
• Viewable via /profile/{username}
• Shows bio, skills, and public projects
• Must keep at least some projects for two developers and view their project
6. Database 🔹
• Users, Projects, Skills tables
• Pivot table for project-tech-skills (many-to-many)
• Optional: Use enums or constants for skill types

⚙️ Tech Stack & Tools
Area Stack
Frontend Vue.js 3 + Tailwind CSS
Backend Laravel 10+
API Layer Laravel API or Inertia
Auth Laravel Breeze or Sanctum
DB SQLite
Image Upload Laravel Filesystem or base64 with

preview