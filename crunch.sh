crunch 3 3 ABCDEFGHIJKLMNOPQRSTUVWXYZ | while read bloco; do
  echo "CRUNCH BLOCO $bloco"
  DIR_GROUNDTRUTH="/srv/tesstrain/${bloco}"
  mkdir $DIR_GROUNDTRUTH
  DIR_GROUNDTRUTH="$DIR_GROUNDTRUTH/plc-ground-truth"
  mkdir $DIR_GROUNDTRUTH
  
  BLOCO_JOBS=()

  # copy gen data
  cp /srv/gerador/FE-FONT.ttf $DIR_GROUNDTRUTH \
  && cp /srv/gerador/gerar-placa.php $DIR_GROUNDTRUTH \
  && cp /srv/gerador/MANDATOR.ttf $DIR_GROUNDTRUTH \
  && cp /srv/gerador/bg-brasil.png $DIR_GROUNDTRUTH \
  && cp /srv/gerador/bg-mercosul.png $DIR_GROUNDTRUTH

  # gerar placas
  cd $DIR_GROUNDTRUTH
  PLACAS=()
  while read placa; do
    echo $placa | php gerar-placa.php & PLACAS+=($!)
  done < <(crunch 8 8 -d 3,% -t "${bloco}-%,%%")
  wait ${PLACAS[@]}

  # treinar
  cd /srv/tesstrain
  make training MODEL_NAME=plc PSM=7 CORES=`nproc` PROTO_MODEL=/srv/tesstrain/data/plc.traineddata GROUND_TRUTH_DIR=$DIR_GROUNDTRUTH & BLOCO_JOBS+=($!)

  echo "######### WAIT FOR ${BLOCO_JOBS[@]}"
  wait ${BLOCO_JOBS[@]}

  # limpar
  rm -rf $DIR_GROUNDTRUTH_BLOCO
done