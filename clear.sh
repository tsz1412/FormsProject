#!/bin/bash
# Stop all running containers
read -n1 -p "Stop all running containers? [y,n]" doit
case $doit in
  y|Y) docker stop $(docker ps -aq); echo Done ;;
  *) echo dont know ;;
esac

# Delete all containers
read -n1 -p "Delete all containers? [y,n]" doit
case $doit in
  y|Y) docker rm $(docker ps -a -q) -f; echo Done ;;
  *) echo dont know ;;
esac

# Delete all images
read -n1 -p "Delete all images? [y,n]" doit
case $doit in
  y|Y) docker rmi $(docker images -q) -f; echo Done ;;
  *) echo dont know ;;
esac

# Delete all volumes
read -n1 -p "Delete all volumes? [y,n]" doit
case $doit in
  y|Y) docker volume prune; echo Done ;;
  *) echo dont know ;;
esac
