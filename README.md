Indigo
================================================================================

* Author: Steve Phillips   
  <http://stevephillips.me>
* Version: alpha
* License: GPL 3

Assertion
--------------------------------------------------------------------------------

A highly modular, minimalistic PHP 5.3+ framework that manages the essential 
functions of a web request, without forcing design constraints and allowing
any functionality that can be overridden to be overridden.

About
--------------------------------------------------------------------------------

The Indigo framework is a concise, yet robust framework. It is the result of 
several self-made frameworks, with influence from Drupal and Kohana. I began 
this project after building a basic, decent framework while overhauling an 
existing code base. I liked where the system was going and wanted to separate it 
from the existing application into something that can be quickly deployed 
elsewhere.

It takes heavy inspiration from Drupal and Kohana in its overall structure, but 
aims to reduce the overhead of Drupal and improve the flexibility of Kohana. The
end result aims to be a minimalistic MVC that handles basic form validation, 
user login, permissions, GET/POST processing and other basic features, all 
without forcing any design constraints on the end user.

Goals
--------------------------------------------------------------------------------

Indigo's goals are subject to change at any time. The goals should never violate
the assertion listed above. As this project progresses, the goals will become
more refined. The goal list should not grow considerably, and if changes are to
be made it is preferred that the goal list be reduced rather than increased.

Any excessive goals can always be turned into a module, and feature creep should
be closely monitored. 

1. Create a router that can map a route to a controller/page in a style similar
   to Drupal, encouraging hierarchical URLs and not forcing a strict 
   {controller}/{page} format. User permissions will be provided by the routes 
   to restrict access prior to the page ever being loaded, as well as 
   restricting access to links.
2. Create models that are similar to Kohana's, emplying PDO and the strategy 
   pattern to allow for multiple database storage engines. This will require 
   a robust query builder.  The models will also employ my magic column 
   pattern for dynamic member properties. In addition, the models will 
   include field validation as a member property to ensure data passes 
   validation.
3. Incorporate user logins and sessions into the core, while not forcing any 
   particulars such as the HTML of the login form, the hashing method for the 
   passwords (while supporting both bcrypt and PBKDF2 by default), or even the 
   table name/fields. User permissions will also be handled in a style 
   inspired by Drupal's permission/role system.
4. Provide an HTML library that handles commonly used functionality, such as 
   menus, links forms, selects, etc., without forcing HTML markup. This will be 
   done through Drupal inspired .tpl.php files that can be overridden on 
   multiple levels - at the system, in a theme, in a module or in the 
   application itself.
5. Create a system folder that is separate from a sites folder, similar to 
   Drupal's sites folder. This will allow a single core install to be used by 
   multiple sites, each one with its own dependencies.
6. Manage dependencies with composer, allowing the core and each site to 
   specify different versions of packages to be used, similar to Drupal's 
   modules, sites/all/modules and sites/{site}/modules. Eventually, Indigo
   could have its own Composer repository of modules.
7. Force high security on sessions and form processing without the application 
   developer having to worry about anything, unless they want to.
8. Rely on exceptions and exception handling to deal with critical errors. This
   includes:
   * When a model attempts to be saved with data that does not match validation,
     throw a ModelException.
   * When a user tries to access a page that is not allowed under current 
     permissions, throw an AuthException.
   * When a form or session security violation is critical, throw a 
     SecurityException.
   * When a page does not exist, through a RouterException.
9. Use an event system similar to Kohana's 2.3 hooks that allows any module to
   modify the behavior of core functionality without having to modify the core
   itself. Events will have distinct, appropriate names and provide necessary
   information to the event handler, and appropriately react to changed
   behavior.

Copyright
--------------------------------------------------------------------------------
Copyright (C) 2012 Steve Phillips

This file is part of Indigo.

Indigo is free software: you can redistribute it and/or modify it under the 
terms of the GNU General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later 
version.

Indigo is distributed in the hope that it will be useful, but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE.  See the GNU General Public License for more details.  

You should have received a copy of the GNU General Public License along with 
Indigo.  If not, see <http://www.gnu.org/licenses/>.

