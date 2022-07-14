@ECHO OFF
docker build . -t omeka_s_slimerfgoed
docker tag omeka_s_slimerfgoed registry.docker.libis.be/omeka_s_slimerfgoed
docker push registry.docker.libis.be/omeka_s_slimerfgoed
ECHO Image built, tagged and pushed succesfully
PAUSE
