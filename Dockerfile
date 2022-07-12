FROM apiphp_ivannack:version4

#copiar projeto para imagem e corrigir dono
#RUN mkdir /var/www/html/apiphp
COPY ./apiphp /var/www/html/apiphp



