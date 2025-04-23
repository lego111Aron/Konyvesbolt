# Konyvesbolt (Adatbázis alapú rendszerek projekt)

A projekt futtatásához szükséges a `PuTTY` és a `XAMPP` apache szerver.

- A projekt futtatásához indítsuk el a **XAMPP**-ot.
    -  Indítsuk az apache szervet.
- Indítsuk el **PUTTY**-t.
    - Bal oldalon ──> Connection ──> SSH ──> Tunnels
        - Source port: `1521`
        - Destination: `orania2.inf.u-szeged.hu:1521`
    - Bal oldalon ──> Session
        - Host Name (or IP address): `linux.inf.u-szeged.hu`
    - Az Open gomb megnyomásával indítsuk el a kapcsolatot 

---

Ezek elindítását követően a projekt elérhető az alábbi linken: http://localhost/Konyvesbolt/Front-end/

Abban az esetben ha le szeretné ellenőrizni, hogy van-e aktuálisan bejelentkezett felhasználó, esetleg, hogy mi a felhasználók tábla tartalma az adatbázisban ezt megteheti az alábbi linken: http://localhost/Konyvesbolt/Back-end/authentication/test.php