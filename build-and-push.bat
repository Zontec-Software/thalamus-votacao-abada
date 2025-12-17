@echo off
REM Script para buildar e fazer push da imagem Docker no Windows
REM Uso: build-and-push.bat [tag]
REM Exemplo: build-and-push.bat latest

set IMAGE_NAME=devroboflex/thalamus-votacao-abada
set TAG=%1
if "%TAG%"=="" set TAG=latest

echo Building Docker image: %IMAGE_NAME%:%TAG%
docker build -t %IMAGE_NAME%:%TAG% .

if %ERRORLEVEL% EQU 0 (
    echo Build successful! Pushing to Docker Hub...
    docker push %IMAGE_NAME%:%TAG%
    
    if %ERRORLEVEL% EQU 0 (
        echo Push successful! Image %IMAGE_NAME%:%TAG% is now available.
    ) else (
        echo Error: Failed to push image. Make sure you're logged in to Docker Hub.
        echo Run: docker login
        exit /b 1
    )
) else (
    echo Error: Build failed!
    exit /b 1
)

