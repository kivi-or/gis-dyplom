import subprocess
list_files = subprocess.run(["gdal_rasterize", "-ts", "1000", "1000", "-a", "suma_danych", "-a_nodata", "999", "nowy_slownik_testowy.geojson", "raster/ludnosc.tif"])
