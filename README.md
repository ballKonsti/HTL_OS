<div align="center">

```
██╗  ██╗████████╗██╗          ██████╗ ███████╗
██║  ██║╚══██╔══╝██║         ██╔═══██╗██╔════╝
███████║   ██║   ██║         ██║   ██║███████╗
██╔══██║   ██║   ██║         ██║   ██║╚════██║
██║  ██║   ██║   ███████╗    ╚██████╔╝███████║
╚═╝  ╚═╝   ╚═╝   ╚══════╝     ╚═════╝ ╚══════╝
```

### 🎮 Ein interaktiver 3D-Rundgang durch die HTL Villach 🎮

*Scroll dich durch die Gänge. Wähl deine Abteilung. Betritt die Räume. Finde, was versteckt ist.*

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-4169E1?style=for-the-badge&logo=postgresql&logoColor=white)
![Three.js](https://img.shields.io/badge/Three.js-000000?style=for-the-badge&logo=threedotjs&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)

`[ PRESS START ]`

</div>

---

## 🕹️ Das Spiel

**HTL OS** macht aus einem Schulbesuch ein Spiel. Statt eine Broschüre zu lesen, **läufst du selbst durch die HTL Villach**, direkt im Browser:

| | |
|---|---|
| 🚶 **Erkunden** | Scrolle durch Gänge und Stiegenhäuser, Foto für Foto |
| 🧭 **Entscheiden** | Wähl im Stiegenhaus deine Abteilung: Informatik, Bautechnik und mehr |
| 🚪 **Betreten** | Drück **E** vor einem Raum und Lehrer:innen erklären dir, was dort passiert |
| 🥚 **Entdecken** | Manche Wege stehen auf keinem Plan … |

> **Zielgruppe:** zukünftige Schüler:innen, Eltern und alle Besucher:innen beim Tag der offenen Tür.

---

## 🎮 Steuerung

```
        ┌─────┐
        │  W  │   vorwärts          🖱️  Mausrad  →  gehen
  ┌─────┼─────┼─────┐               📱  Wischen  →  gehen
  │  A  │  S  │  D  │               ⌨️  E        →  Raum betreten
  └─────┴─────┴─────┘               ⌨️  ESC      →  Raum verlassen
  links  zurück  rechts
```

---

## 🗺️ Die Welt: ein Node-Graph

Die ganze Schule ist ein **Graph aus Nodes**. Jeder Node ist ein Foto und kennt seine Nachbarn in alle vier Richtungen:

```
                  ┌──────────┐
                  │  Node 3  │
                  │ Stiege 🪜│
                  └────▲─────┘
                       │ forward
  ┌──────────┐    ┌────┴─────┐    ┌──────────┐
  │  Node 4  │◄───┤  Node 2  ├───►│  Node 5  │
  │ EDV-Saal │left│  Gang 🚶 │right│ Labor 🔬│
  └──────────┘    └────▲─────┘    └──────────┘
                       │ back
                  ┌────┴─────┐
                  │  Node 1  │
                  │Eingang 🏫│
                  └──────────┘
```

Ein `null` heißt **„Hier geht's nicht weiter.“** 🧱

<details>
<summary>📜 <b>Tabelle <code>nodes</code> anzeigen</b></summary>

| Spalte | Typ | Bedeutung |
|---|---|---|
| `id` | bigint | Eindeutige Node-ID |
| `name` | string, unique | Lesbarer Name, z. B. `ugg_1` |
| `pic_url` | string | Pfad zum Foto |
| `forward_id` · `back_id` · `left_id` · `right_id` | FK → `nodes.id`, nullable | Die Nachbarn |
| `node_type` | string | `hallway` · `stairwell` · `room` |
| `department` | string, nullable | z. B. `informatik` |
| `room_name` · `teacher_name` · `teacher_image` | string, nullable | Raum-Infos |
| `dialogue_text` | text, nullable | Was die Lehrperson erzählt |
| `project_images` | json, nullable | Galerie mit Schülerprojekten |

</details>

---

## 🛡️ Die Party

| | Klasse | Skills |
|---|---|---|
| ⚔️ **Konstantin** | *Teamleiter · Backend-Magier* | Datenbank, Admin-Panel, API, 3D-Logik, Deployment |
| 🎨 **Anna** | *Design-Bardin* | UI/UX, HTML, Tailwind, Look & Feel |

---

## 📋 Quest-Log

```
HAUPTQUEST: Die Schule digitalisieren                  DEADLINE: 15.01.2027
```

**Akt I: Das Fundament** ⚔️
- [x] Datenbank-Dungeon errichten (`nodes`-Tabelle)
- [x] Eloquent-Model beschwören
- [x] Bilder-Upload freischalten
- [x] Nodes speichern und verknüpfen
- [x] Live-Bildvorschau
- [ ] Dropdowns für Verbindungen
- [ ] Bearbeiten-Modus + Raum-Infos
- [ ] API-Portal öffnen (`/api/nodes`)

**Akt II: Die Welt** 🌍
- [ ] 3D-Szene mit Three.js
- [ ] Bewegung per Scrollen, Tasten und Wischen
- [ ] GSAP-Übergänge zwischen den Nodes
- [ ] Stiegenhaus-Menü und Raum-Ansicht

**Akt III: Das Finale** 🏆
- [ ] ??? 🥚
- [ ] Mobile-Feinschliff
- [ ] Release auf dem Schul-Server

---

## 🚀 Spiel starten (lokales Setup)

> **Voraussetzungen:** PHP 8.3+ · Composer · Node.js · PostgreSQL

```bash
# 1. Repo klonen
git clone git@github.com:ballKonsti/HTL_OS.git && cd HTL_OS

# 2. Abhängigkeiten laden
composer install
npm install

# 3. Konfiguration (danach DB_* in .env auf deine PostgreSQL-Datenbank setzen)
cp .env.example .env
php artisan key:generate

# 4. Welt erschaffen
php artisan migrate
php artisan storage:link

# 5. PRESS START 🎮
composer run dev
```

| Wo | Was |
|---|---|
| `/` | Startseite |
| `/admin` | 🛠️ Level-Editor: Fotos hochladen und Nodes verknüpfen |

---

## 🧰 Inventar (Tech-Stack)

```
╔══════════════════╦═══════════════════════════════════════╗
║ 🗡️  Backend       ║ Laravel 13 · PHP 8.5 · Eloquent        ║
║ 🛡️  Datenbank     ║ PostgreSQL                             ║
║ 🔮 Level-Editor  ║ Livewire 4 · Tailwind CSS 4            ║
║ 🌍 3D-Welt       ║ Three.js · GSAP                        ║
║ ⚙️  Build         ║ Vite                                   ║
║ 🧪 Tests         ║ Pest                                   ║
╚══════════════════╩═══════════════════════════════════════╝
```

---

<div align="center">

**Diplomprojekt · HTL Villach · 2026/27**

`GAME OVER? Nein. Jetzt fängt's erst an.` 🎓

</div>
