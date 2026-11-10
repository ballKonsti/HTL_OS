# HTL OS – Design-Aufgaben (Anna)

Du gestaltest das **Aussehen** des Rundgangs: alle Bildschirme und Overlays, die Besucher:innen sehen. Die Logik (3D-Szene, Scrollen, Navigation, Daten) baut Konstantin und hängt sie an deine Komponenten an.

## Regeln

- **Nur HTML + Tailwind**, als Blade-Komponenten in `resources/views/components/tour/`. Kein JavaScript.
- **Platzhalter-Texte** statt echter Daten (z. B. „Prof. Muster“, „Informatik“, „EDV-Saal 3“).
- **Die vorgegebenen `id`- und `data-*`-Attribute bitte nicht umbenennen oder entfernen.** Daran hängt Konstantin die Logik. Zusätzliche Klassen und Elemente kannst du frei hinzufügen.
- **Mobil und Desktop**: Gestalte zuerst fürs Handy, dann mit `md:` / `lg:` für größere Bildschirme.
- **Vorschau:** A1 und A7 siehst du direkt auf `/`. Für die anderen Komponenten richtet Konstantin die Seite `/design-preview` ein.
- **Git:** Jede Aufgabe kommt auf einen eigenen Branch (z. B. `design/a2-hud`). Fertig heißt: kurze Demo an Konstantin, er hakt die Aufgabe ab und merged.
- **Stil:** Den Look entscheidest du.

## ⚠️ Wichtig: Admin-Komponenten

Deine Admin-Komponenten (`resources/views/components/admin/`) sind jetzt mit Livewire verbunden und speichern in die Datenbank. Bitte diese Dinge **nicht zurückändern**:

- `wire:model`-Namen: `photo`, `forward_id`, `back_id`, `left_id`, `right_id`
- `image-upload`: nur **ein** Bild (kein `multiple`), plus Fehlermeldung `@error('photo')`
- `admin-inputs`: `type="number"`, ein `<div>` außen herum, Fehlermeldung `@error($model)`
- `admin-button`: `type="button"`

Am Aussehen (Klassen, Farben, Abstände) kannst du jederzeit weiterarbeiten.

## Aufgaben

Empfohlene Reihenfolge: **A7 + A1 → A2 → A3 → A4 → A5**

- [ ] **A7 – Farb- & Schrift-System**
  Lege Farben und Schriften als Tailwind-Theme in `resources/css/app.css` fest (im `@theme`-Block), damit alle Komponenten gleich aussehen. Zum Beispiel eine Hauptfarbe, eine Akzentfarbe, Hintergrund, Text und eine Farbe pro Abteilung.

- [ ] **A1 – Startseite = Ladebildschirm**
  Datei: `resources/views/home.blade.php` (ersetzt das aktuelle „Hello world“)
  Inhalt: Die erste Seite, die man sieht, während der Rundgang lädt. Logo/Schriftzug, Fortschrittsbalken und Lade-Text. Danach erscheint ein „Rundgang starten“-Button.
  Hooks:
  - `id="boot-screen"` am äußeren Container
  - `id="boot-progress"` am Balken, der sich füllt (Konstantin setzt die Breite von 0–100 %)
  - `id="boot-text"` am Lade-Text (z. B. „Lade Informatik …“)
  - `id="start-tour"` am Start-Button

- [ ] **A2 – HUD / Steuerungs-Overlay**
  Datei: `resources/views/components/tour/hud.blade.php`
  Inhalt: Liegt während des Rundgangs über dem Foto. 4 Richtungspfeile, eine Anzeige „wo bin ich“ (Abteilung/Ort) und ein Bedienhinweis („Scrollen zum Gehen“).
  Hooks:
  - `data-arrow="forward"`, `data-arrow="back"`, `data-arrow="left"`, `data-arrow="right"` an den Pfeilen
  - `id="hud-location"` an der Ortsanzeige
  - `id="hud-hint"` am Bedienhinweis
  Tipp: Gestalte auch, wie ein Pfeil aussieht, wenn es in diese Richtung **nicht weitergeht**. Mach dafür eine zweite Variante mit `opacity-30` o. Ä. als Beispiel.

- [ ] **A3 – „E zum Betreten“-Hinweis**
  Datei: `resources/views/components/tour/enter-prompt.blade.php`
  Inhalt: Erscheint vor einem Raum. Ein Tasten-Symbol „E“ mit Text. Auf dem Handy wird stattdessen ein Button angezeigt, den man antippt.
  Hook: `id="enter-prompt"`

- [ ] **A4 – Stiegenhaus-Menü**
  Datei: `resources/views/components/tour/stairwell-menu.blade.php`
  Inhalt: Im Stiegenhaus wählt man die Abteilung (Informatik, Bautechnik, Elektrotechnik, …). Jede Abteilung bekommt ein Icon und ihre Farbe aus A7.
  Hooks:
  - `id="stairwell-menu"` am Container
  - `data-department="informatik"` (usw.) an jedem Eintrag

- [ ] **A5 – Raum-Ansicht**
  Datei: `resources/views/components/tour/room-view.blade.php`
  Inhalt: Öffnet sich, wenn man einen Raum betritt. Raumname, Foto und Name der Lehrperson, eine Dialogbox mit Erklärungstext, eine Galerie mit Projektbildern und ein Schließen-Button.
  Hooks:
  - `id="room-view"` am Container
  - `id="room-name"`
  - `id="room-teacher-name"`
  - `id="room-teacher-image"` (das `<img>`)
  - `id="room-dialogue"` (der Text)
  - `id="room-gallery"` (Container für die Projektbilder; Konstantin füllt die Bilder ein)
  - `id="room-close"` (Schließen-Button)

## Bei Fragen

Bei Fragen zu Daten (welche Texte gibt es, wie lang können sie sein) oder Hooks: Konstantin fragen. Beim Design entscheidest du.
