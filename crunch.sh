crunch 3 3 ABCDEFGHIJKLMNOPQRSTUVWXYZ | while read bloco; do
  echo "CRUNCH BLOCO $bloco"

  cd /srv/tesstrain/data/plc-ground-truth && crunch 8 8 -d 3,% -t "${bloco}-%,%%" | php gerar-placa.php
#  cd /srv/tesstrain/data/plc-ground-truth && crunch 8 8 -d 3,% -t "${bloco}-1234" | php gerar-placa.php # teste

  cd /srv/tesstrain && make training MODEL_NAME=plc PSM=7 CORES=`nproc`

  cd /srv/tesstrain/data/plc-ground-truth/ \
  && rm -rf *.lstmf \
  && rm -rf *.txt \
  && rm -rf *.tif \
  && rm -rf *.box
done