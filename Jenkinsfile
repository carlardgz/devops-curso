pipeline {
	environment{
		dockerImageName1 = "carlarodriguezag/app:devops"
		dockerImage1 = ""
		dockerImageName2 = "carlarodriguezag/phpmyadmin:devops"
		dockerImage2 = ""
		SONAR_SCANNER_HOME = "/opt/sonar-scanner"
    	PATH = "${env.SONAR_SCANNER_HOME}/bin:${env.PATH}"
	}

 	agent any

	stages {
		stage('Revisar Código'){
	  		  steps {
                git credentialsId: 'dockerhub_curso' , url: 'https://github.com/carlardgz/devops-curso.git', branch: 'main'
            }
	 	}

		stage('Static Code Analysis') {
      		steps {
        		withSonarQubeEnv('sonarqube') {
         		sh "${env.SONAR_SCANNER_HOME}/bin/sonar-scanner \
					-Dsonar.projectKey=aplicacion \
					-Dsonar.projectName=aplicacion \
					-Dsonar.projectVersion=1.0 \
					-Dsonar.sources=aplicacion \
					-Dsonar.language=php \
					-Dsonar.password=\$(sonarqubeGlobal) \
					-Dsonar.host.url=http://scanner.ucol.mx:9000 \
					-Dsonar.report.export.path=sonar-report.json"
        		}
      		}
   		}

		stage('Construir Imagen') {
	  		steps{
	   			dir('aplicacion'){
	    			script {
	     				dockerImage1 = docker.build dockerImageName1
	    			}
	   			}

	    		dir('Phpmyadmin'){
	    			script {
	     				dockerImage2 = docker.build dockerImageName2
	    			}
	   			}
	  		}
	 	} 

	 	stage('Subir Imagen') {
	  		environment {
	   			registryCredential = 'dockerhub_curso'
	   		}
	  		steps {
				dir('aplicacion') {
		 			script {
						docker.withRegistry('https://registry.hub.docker.com', registryCredential) {
							dockerImage1.push("devops")
			 			}
					}
				}
		 		dir('Phpmyadmin') {
		 			script {
						docker.withRegistry('https://registry.hub.docker.com', registryCredential) {
							dockerImage2.push("devops")
			 			}
					}
				}
	    	}
      	}
	  
	 
		stage('Correr POD') {
		 	steps{
		   		sshagent(['rodriguezssh']) {
			 		sh 'cd aplicacion && scp -r -o StrictHostKeyChecking=no deploymentcursoaplicacion.yaml digesetuser@148.213.1.131:/home/digesetuser/'
      				script{
       	 				try{
           					sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl apply -f deploymentcursoaplicacion.yaml --kubeconfig=/home/digesetuser/.kube/config'
           					sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl rollout restart deployment app -n aplicacioncurso --kubeconfig=/home/digesetuser/.kube/config' 
           					//sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl rollout status deployment app -n aplicacioncurso --kubeconfig=/home/digesetuser/.kube/config'
          				}catch(error)
       					{}
					}

					sh 'cd Mysql && scp -r -o StrictHostKeyChecking=no deploymentcursomysql.yaml digesetuser@148.213.1.131:/home/digesetuser/'
      				script{
       	 				try{
           					sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl apply -f deploymentcursomysql.yaml --kubeconfig=/home/digesetuser/.kube/config'
           					sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl rollout restart deployment mysql-deployment -n aplicacioncurso --kubeconfig=/home/digesetuser/.kube/config' 
           					//sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl rollout status deployment mysql-deployment -n aplicacioncurso --kubeconfig=/home/digesetuser/.kube/config'
          				}catch(error)
       					{}
					}

					sh 'cd Phpmyadmin && scp -r -o StrictHostKeyChecking=no deploymentcursoadmin.yaml digesetuser@148.213.1.131:/home/digesetuser/'
      				script{
       	 				try{
           					sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl apply -f deploymentcursoadmin.yaml --kubeconfig=/home/digesetuser/.kube/config'
           					sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl rollout restart deployment phpmyadmin-deployment -n aplicacioncurso --kubeconfig=/home/digesetuser/.kube/config' 
           					//sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl rollout status deployment phpmyadmin-deployment -n aplicacioncurso --kubeconfig=/home/digesetuser/.kube/config'
          				}catch(error)
       					{}
					}
				}
		
			}		
		}
	}

	post{
        success{
            slackSend channel: 'carla', color: 'good', failOnError: true, message: "${custom_msg()}", teamDomain: 'universidadde-bea3869', tokenCredentialId: 'slackpass' 
		}
      }
   }
  def custom_msg()
  {
  def JENKINS_URL= "jarvis.ucol.mx:8080"
  def JOB_NAME = env.JOB_NAME
  def BUILD_ID= env.BUILD_ID
  def JENKINS_LOG= " DEPLOY LOG: Job [${env.JOB_NAME}] Logs path: ${JENKINS_URL}/job/${JOB_NAME}/${BUILD_ID}/consoleText"
  return JENKINS_LOG
}

