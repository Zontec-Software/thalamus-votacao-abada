#!/bin/bash

# Script para buildar e fazer push da imagem Docker
# Uso: ./build-and-push.sh [tag]
# Exemplo: ./build-and-push.sh latest

IMAGE_NAME="devroboflex/thalamus-votacao-abada"
TAG=${1:-latest}

echo "Building Docker image: ${IMAGE_NAME}:${TAG}"
docker build -t ${IMAGE_NAME}:${TAG} .

if [ $? -eq 0 ]; then
    echo "Build successful! Pushing to Docker Hub..."
    docker push ${IMAGE_NAME}:${TAG}
    
    if [ $? -eq 0 ]; then
        echo "Push successful! Image ${IMAGE_NAME}:${TAG} is now available."
    else
        echo "Error: Failed to push image. Make sure you're logged in to Docker Hub."
        echo "Run: docker login"
        exit 1
    fi
else
    echo "Error: Build failed!"
    exit 1
fi

