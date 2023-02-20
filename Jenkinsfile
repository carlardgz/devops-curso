pipeline {
	environment{
		dockerImageName1 = "carlarodriguezag/app:devops"
		dockerImage1 = ""
		dockerImageName2 = "carlarodriguezag/phpmyadmin:devops"
		dockerImage2 = ""
		dockerImageName3 = "carlarodriguezag/mysql:devops"
		dockerImage3 = ""
	}

 	agent any

	stages {
		stage('Revisar Código'){
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
	   			dir('Mysql'){
	    			script {
	     				dockerImage3 = docker.build dockerImageName3
	    			}
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

	    		dir('Mysql'){
	    			script {
	     				dockerImage3 = docker.build dockerImageName3
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
		 
		 		dir('Mysql') {
		 			script {
						docker.withRegistry('https://registry.hub.docker.com', registryCredential) {
							dockerImage3.push("devops")
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
           					sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl rollout restart deployment aplicacion --kubeconfig=/home/digesetuser/.kube/config' 
           					//sh 'ssh digesetuser@148.213.1.131 microk8s.kubectl rollout status deployment aplicacion --kubeconfig=/home/digesetuser/.kube/config'
          				}catch(error)
       					{}
					}
				}
		
			}		


		}
	}
}

