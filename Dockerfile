FROM debian:10

RUN apt update
RUN apt install build-essential -y

# tesseract
RUN apt install tesseract-ocr -y

# tesstrain dep.
RUN apt install python3 python3-pip python3-pillow -y

# php stuff
RUN apt install php php-gd -y

# commom
RUN apt install git vim crunch bc curl wget -y

# treinar
# https://github.com/tesseract-ocr/tesstrain
# https://medium.com/@guiem/how-to-train-tesseract-4-ebe5881ff3b7
COPY . /srv/gerador
RUN rm -rf /srv/gerador/plc.traineddata
RUN cd /srv && git clone https://github.com/tesseract-ocr/tesstrain.git

RUN cd /srv/tesstrain \
&& mkdir data \
&& cd data \
&& mkdir plc-ground-truth \
&& cp /srv/gerador/* /srv/tesstrain/data/plc-ground-truth/

RUN cd /srv/tesstrain/data/plc-ground-truth/ \
&& crunch 8 8 -d 1,% -t ,OD-0%1% | php gerar-placa.php brasil

RUN cd /srv/tesstrain/data/plc-ground-truth/ \
&& crunch 7 7 -d 1,% -t DO,0,%0 | php gerar-placa.php mercosul

RUN cd /srv/tesstrain/data/plc-ground-truth/ \
&& rm *.ttf \
&& rm *.php \
&& rm *.yml \
&& rm Dockerfile

RUN cd /srv/tesstrain \
&& make training MODEL_NAME=plc PSM=7