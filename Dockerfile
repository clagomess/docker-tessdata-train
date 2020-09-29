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
&& cp /srv/gerador/crunch.sh /srv/tesstrain/data/plc-ground-truth/ \
&& cp /srv/gerador/FE-FONT.ttf /srv/tesstrain/data/plc-ground-truth/ \
&& cp /srv/gerador/gerar-placa.php /srv/tesstrain/data/plc-ground-truth/ \
&& cp /srv/gerador/MANDATOR.ttf /srv/tesstrain/data/plc-ground-truth/ \
&& cp /srv/gerador/bg-brasil.png /srv/tesstrain/data/plc-ground-truth/ \
&& cp /srv/gerador/bg-mercosul.png /srv/tesstrain/data/plc-ground-truth/

## loop
RUN cd /srv/tesstrain/data/plc-ground-truth/ && bash -c ./crunch.sh