Demo App: Developer Invoice
=======================

This is an implementation of an invoicing system. The backend is ZF2 with Doctrine and ZfcUser. The frontend is a simple
bootstrap app with jQuery to provide the simple in-page dynamic features.

This should illustrate well how I would approach this problem: use off-the-shelf packages where available, take
advantage of the Zend Form validation, use Doctrine, OOP principles, etc.

The form fill on PDFs is done using PdfTk. See Application\Pdf\InvoicePdf for the class to create a PDF from an Invoice
entity.

Technologies not used here that I typically would for normal projects:
- Bower
- Vagrant
- PhpUnit
- Behat
- Grunt

Live Demo
=========
I had too many incorrect login attempts when SSHing to my host. Since I'm locked out until my support ticket is
addressed, I stored screenshots in /docs/ to cover the features.