pipeline {
    agent any

    environment {
        DOCKER_REPO = 'tata197'
        IMAGE_NAME = 'eatjoy-tubes'
        DOCKER_CREDENTIALS = 'dockerhub-credentials'
    }

    stages {

        stage('Checkout Repository') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                bat """
                docker build ^
                  -t %DOCKER_REPO%/%IMAGE_NAME%:%BUILD_NUMBER% ^
                  -t %DOCKER_REPO%/%IMAGE_NAME%:latest .
                """
            }
        }

        stage('Push Image to Docker Hub') {
            steps {
                withCredentials([usernamePassword(
                    credentialsId: DOCKER_CREDENTIALS,
                    usernameVariable: 'DOCKER_USER',
                    passwordVariable: 'DOCKER_PASS'
                )]) {
                    bat """
                    echo %DOCKER_PASS% | docker login -u %DOCKER_USER% --password-stdin
                    docker push %DOCKER_REPO%/%IMAGE_NAME%:%BUILD_NUMBER%
                    docker push %DOCKER_REPO%/%IMAGE_NAME%:latest
                    """
                }
            }
        }

        stage('Pipeline Summary') {
            steps {
                echo """
                =====================================
                CI/CD EATJOY-TUBES SELESAI
                Image:
                - %DOCKER_REPO%/%IMAGE_NAME%:%BUILD_NUMBER%
                - %DOCKER_REPO%/%IMAGE_NAME%:latest
                =====================================
                """
            }
        }
    }

    post {
        success {
            echo '✅ Pipeline berhasil dijalankan'
        }
        failure {
            echo '❌ Pipeline gagal, cek log Jenkins'
        }
        always {
            cleanWs()
        }
    }
}
