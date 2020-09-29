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
RUN apt install git vim crunch bc curl wget parallel -y

# treinar
# https://github.com/tesseract-ocr/tesstrain
# https://medium.com/@guiem/how-to-train-tesseract-4-ebe5881ff3b7
RUN cd /srv \
&& git clone --progress https://github.com/tesseract-ocr/tesstrain.git \
&& cd /srv/tesstrain \
&& mkdir data

COPY . /srv/gerador
RUN rm -rf /srv/gerador/plc.traineddata

## loop
RUN bash -c /srv/gerador/crunch.sh