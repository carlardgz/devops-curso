pipeline {
	environment{
		dockerImageName1 = "carlarodriguezag/app:devops"
		dockerImage1 = ""
		dockerImageName1 = "carlarodriguezag/phpmyadmin:devops"
		dockerImage2 = ""
	}

 	agent any

	stages {
		stage('Revisar Código'){
	  		  steps {
                git credentialsId: 'dockerhub_curso' , url: 'https://github.com/carlardgz/devops-curso.git', branch: 'main'
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
			 		sh 'cd aplicacion && scp -r -o StrictHostKeyChecking=no deployment.yaml digesetuser@148.213.1.131:/home/digesetuser/'
      				script{
       	 				try{
           					sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl apply -f deployment.yaml --kubeconfig=/home/digesetuser/.kube/config'
           					sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl rollout restart deployment aplicacion -n aplicacion --kubeconfig=/home/digesetuser/.kube/config' 
           					sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl rollout status deployment aplicacion -n aplicacion --kubeconfig=/home/digesetuser/.kube/config'
          				}catch(error)
       					{}
					}
				}
		
			}		


		}
	}
}

