from funkcje_kody import *
import subprocess

# importowanie slownika z pliku csv 1 kolumna ulica, kolumna 0 to kod teryt
teryt = teryt_load('csv/ulice_kod_full.csv', 1, 0, ',')
#importowanie z jsona punktow adresowych-geojson
adresy = load_json_dict('input_file_dir/pkt_adresowe.geojson') 
#importowanie siatki 1000x1000-geojson
grid = load_json_dict('siatka_1000/siatka_slupsk_1000.geojson')
#wgranie pliku z danymi z pliku csv
#wgranie danych z meldunkow
dane = meldunki_do_slownik('csv/lud_utf8.csv',';')
# dane = ulice_dane_load_csv("csv/ulica_numer_dana.csv",0, 1, 2, ',', teryt)
# dodanie teryt do adresow
adres_teryt = add_teryt_to_adresy_geojson(adresy, teryt)
#dodanie danych do adresow
adres_teryt_data = add_data_to_ulice(adres_teryt, dane,0)
#dodanie id siatki do kazdego punktu adresowego
adres_teryt_data_grid = dod_do_adres_grid_id(adres_teryt_data, grid)
#dodanie danych data do siatki
grid_data = add_data_to_gird(grid, adres_teryt_data_grid)
#zapisanie geojson nowy_slownik_tekstowy.geojson
convert_to_json(grid_data, 'nowy_slownik_testowy.geojson')
convert_to_json(adres_teryt_data, 'punty_adresowe_meldunki.geojson')

list_files = subprocess.run(["gdal_rasterize", "-ts", "1000", "1000", "-a", "suma_danych", "-a_nodata", "999", "nowy_slownik_testowy.geojson", "raster/ludnosc.tif"])


