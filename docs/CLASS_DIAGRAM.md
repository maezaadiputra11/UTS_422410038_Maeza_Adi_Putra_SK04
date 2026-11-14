# Class Diagram — SK04 Restorasi Pita Analog

> Render di https://mermaid.live lalu **Export PNG/PDF**, simpan sebagai `docs/CLASS_DIAGRAM.png` (atau `.pdf`).

```mermaid
classDiagram
    class FormatMedia {
        +int id
        +string kode
        +string nama
        +string keterangan
        +koleksiPitas() HasMany
    }
    class KoleksiPita {
        +int id
        +int format_media_id
        +string kode
        +string nama
        +int tahun_rekaman
        +string deskripsi
        +formatMedia() BelongsTo
        +kondisiAwal() HasOne
        +tindakanRestorasis() BelongsToMany
        +scopeSearch()
        +scopeFormat()
        +scopeKerusakan()
        +scopeTindakan()
    }
    class KondisiAwal {
        +int id
        +int koleksi_pita_id
        +string tingkat_kerusakan
        +bool ada_jamur
        +bool sticky_shed
        +date tanggal_periksa
        +string catatan
        +koleksiPita() BelongsTo
    }
    class TindakanRestorasi {
        +int id
        +string nama
        +string deskripsi
        +int estimasi_jam
        +bool aktif
        +koleksiPitas() BelongsToMany
    }
    class KoleksiPitaService {
        +simpan(data, koleksi) KoleksiPita
        -susunPivot(tindakan) array
    }
    class KoleksiPitaController {
        +index() +create() +store()
        +show() +edit() +update() +destroy()
    }
    class KoleksiPitaRequest {
        +rules() array
    }

    FormatMedia "1" --> "0..*" KoleksiPita : hasMany
    KoleksiPita "1" --> "1" KondisiAwal : hasOne
    KoleksiPita "0..*" --> "0..*" TindakanRestorasi : belongsToMany (pivot koleksi_tindakan: prioritas, status)
    KoleksiPitaController ..> KoleksiPitaRequest : validasi
    KoleksiPitaController ..> KoleksiPitaService : memakai
    KoleksiPitaService ..> KoleksiPita : DB::transaction
```
